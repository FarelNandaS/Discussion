<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessReportReward;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\TrustScoreLog;
use App\Models\UserDetail;
use App\Notifications\GetSuspend;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function sendReport(Request $request)
    {
        DB::beginTransaction();
        try {
            $report = new Report();
            $report->reporter_id = auth()->user()->id;
            $reportType = match ($request->reportable_type) {
                'post'=>Post::class,
                'comment'=>Comment::class,
                default => throw new \Exception('the report type is not valid')
            };

            if ($request->reportable_type == 'post') {
                $content = Post::find($request->reportable_id);

                $report->reportable_type = Post::class;
                $report->reported_id = $content->user->id;
            } else if ($request->reportable_type == 'comment') {
                $content = Comment::find($request->reportable_id);

                $report->reportable_type = Comment::class;
                $report->reported_id = $content->user->id;
            }

            $report->reportable_id = $request->reportable_id;
            $report->reason_type = $request->reason_type;
            $report->message = $request->message;

            $report->weight = floor(auth()->user()->detail->trust_score / 10);

            $report->save();

            $reportsWeight = Report::where([
                'reportable_type' => $reportType,
                'reportable_id' => $request->reportable_id
            ])->sum('weight');

            if ($reportsWeight >= 100) {
                DB::table('user_details')->where('user_id', $content->user->id)->update([
                    'trust_score' => DB::raw("LEAST(100, GREATEST(0, trust_score - 10))"),
                    'suspend_until' => now()->addDays(7)
                ]);

                TrustScoreLog::create([
                    'user_id' => $content->user->id,
                    'change' => -10,
                    'reason' => $reportType == Post::class ? 'Your post with title "' . Str::limit($content->title, 50) . '" get a lot of reports' : 'Your comment with content "' . Str::limit($content->content, 50) . '" get a lot of reports',
                    'reference_type' => $content->getMorphClass(),
                    'reference_id' => $content->id,
                ]);

                $content->update([
                    'isDelete' => true
                ]);

                $content->user->notify(new GetSuspend('auto', $content));
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'code' => '200',
                'message' => 'Success to send report'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            // dd($e);
            return response()->json([
                'status' => 'error',
                'code' => '500',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function actionSuspend(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->reportable_type == Post::class) {
                $content = Post::find($request->reportable_id);
            } else if ($request->reportable_type == Comment::class) {
                $content = Comment::find($request->reportable_id);
            }

            Report::where('reportable_type', $request->reportable_type)->where('reportable_id', $request->reportable_id)->update([
                'status' => 'actiond'
            ]);

            TrustScoreLog::create([
                'user_id' => $content->user->id,
                'user_action_id' => auth()->user()->id,
                'change' => -$request->change,
                'reason' => $content->getMorphClass() == Post::class ? 'Your post with title "' . $content->title . '" is get approved by admin contain a violation rules. and the admin reason is: ' . $request->reason : 'Your comment with content "' . $content->content . '" is get approved bt admin contain a violation rules. and the admin reason is: ' . $request->reason,
                'reference_type' => $request->reportable_type,
                'reference_id' => $request->reportable_id,
            ]);

            $change =  $request->integer('change');
            DB::table('user_details')->where('user_id', $content->user->id)->update([
                'trust_score' => DB::raw("LEAST(100, GREATEST(0, trust_score - ($change)))"),
                'suspend_until' => $request->suspend_until,
            ]);

            $content->update([
                'isDelete' => true
            ]);

            $content->user->notify(new GetSuspend('manual', $content, $request->suspend_until, $request->reason));

            ProcessReportReward::dispatch(true, $request->reportable_type, $request->reportable_id, auth()->id());

            DB::commit();

            return redirect()->route('admin-reports')->with('alert', ['type' => 'success', 'message' => 'successfully to action reports']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function actionDismiss(Request $request)
    {
        try {
            $content = $request->reportable_type == Post::class ? Post::find($request->reportable_id) : Comment::find($request->reportable_id);

            Report::where('reportable_type', $request->reportable_type)->where('reportable_id', $request->reportable_id)->update([
                'status' => 'dismiss'
            ]);
            
            $reportsWeight = Report::where([
                'reportable_type' => $content->getMorphClass(),
                'reportable_id' => $content->id,
            ])->sum('weight');

            if ($reportsWeight >= 100) {
                $log = TrustScoreLog::where([
                    'user_id' => $content->user->id,
                    'reference_type' => $content->getMorphClass(),
                    'reference_id' => $content->id,
                ])->first();

                $restoreValue = abs($log->change);

                DB::table('user_details')->where('user_id', $content->user->id)->update([
                    'trust_score' => DB::raw("LEAST(100, GREATEST(0, trust_score + $restoreValue))"),
                    'suspend_until' => null
                ]);

                $content->update([
                    'isDelete' => false
                ]);

                TrustScoreLog::create([
                    'user_id' => $content->user->id,
                    'user_action_id' => auth()->id(),
                    'change' => $restoreValue,
                    'reason' => 'Your content with title "' . Str::limit($content->title ?? $content->content, 30) . '" by admin all reports is not true',
                    'reference_type' => $content->getMorphClass(),
                    'reference_id' => $content->id,
                ]);
            }

            ProcessReportReward::dispatch(false, $request->reportable_type, $request->reportable_id, auth()->id());

            return redirect()->route('admin-reports')->with('alert', ['type' => 'success', 'message' => 'successfully to action reports']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
