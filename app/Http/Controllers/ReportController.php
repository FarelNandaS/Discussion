<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessReportReward;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\TrustScoreLog;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sendReport(Request $request)
    {
        try {
            $report = new Report();
            $report->reporter_id = auth()->user()->id;

            if ($request->reportable_type == 'post') {
                $post = Post::find($request->reportable_id);

                $report->reportable_type = Post::class;
                $report->reported_id = $post->user->id;
            } else if ($request->reportable_type == 'comment') {
                $comment = Comment::find($request->reporable_id);

                $report->reportable_type = Comment::class;
                $report->reported_id = $comment->user->id;
            }

            $report->reportable_id = $request->reportable_id;
            $report->reason_type = $request->reason_type;
            $report->message = $request->message;

            $report->weight = floor(auth()->user()->detail->trust_score / 10);

            $report->save();

            return response()->json([
                'status' => 'success',
                'code' => '200',
                'message' => 'Success to send report'
            ]);

        } catch (\Exception $e) {
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
            }

            Report::where('reportable_type', $request->reportable_type)->where('reportable_id', $request->reportable_id)->update([
                'status' => 'actiond'
            ]);

            TrustScoreLog::create([
                'user_id' => $content->user->id,
                'user_action_id' => auth()->user()->id,
                'change' => -$request->change,
                'reason' => $request->reason,
                'reference_type' => $request->reportable_type,
                'reference_id' => $request->reportable_id,
            ]);

            $userDetailContent = $content->user->detail;
            $userDetailContent->update([
                'trust_score' => $userDetailContent->trust_score - $request->change,
                'suspend_until' => $request->suspend_until,
            ]);

            ProcessReportReward::dispatch(true, $request->reportable_type, $request->reportable_id, auth()->id());

            // $reporterIds = Report::where('reportable_type', $request->reportable_type)->where('reportable_id', $request->reportable_id)->pluck('reporter_id')->unique();

            // if ($reporterIds->isEmpty()) {
            //     return;
            // }

            // $reward = 5;

            // UserDetail::whereIn('user_id', $reporterIds)->increment('trust_score', $reward);

            // $logs = [];
            // foreach ($reporterIds as $id) {
            //     $logs[] = [
            //         'user_id' => $id,
            //         'user_action_id' => auth()->id(),
            //         'change' => $reward,
            //         'reason' => 'The report you provided in the content "' . $content->title ?? $content->content . '" has been validated by the admin',
            //         'reference_type' => $request->reportable_type,
            //         'reference_id' => $request->reportable_id,
            //         'created_at' => now(),
            //         'updated_at' => now()
            //     ];
            // }

            // TrustScoreLog::insert($logs);

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
            Report::where('reportable_type', $request->reportable_type)->where('reportable_id', $request->reportable_id)->update([
                'status' => 'dismiss'
            ]);

            ProcessReportReward::dispatch(false, $request->reportable_type, $request->reportable_id, auth()->id());

            return redirect()->route('admin-reports')->with('alert', ['type'=>'success', 'message'=>'successfully to action reports']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type'=>'error', 'message'=>$e->getMessage()]);
        }
    }
}
