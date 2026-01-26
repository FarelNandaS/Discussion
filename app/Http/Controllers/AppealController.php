<?php

namespace App\Http\Controllers;

use App\Models\Appeals;
use App\Models\Post;
use App\Models\TrustScoreLog;
use App\Notifications\AppealsResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppealController extends Controller
{
    public function submit(Request $request)
    {
        try {
            Appeals::create([
                'user_id' => auth()->id(),
                'notification_id' => $request->notification_id,
                'content_id' => $request->content_id,
                'content_type' => $request->content_type,
                'message' => $request->message,
            ]);

            return redirect()->route('inbox-detail', ['id' => $request->notification_id])->with('alert', ['type' => 'success', 'message' => 'Your appeal submited']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function actiond(Request $request)
    {
        DB::beginTransaction();
        try {
            $appeal = Appeals::find($request->id);
            $content = $appeal->content;

            if ($request->type == 'accept') {
                $log = TrustScoreLog::where([
                    'reference_type' => $appeal->content_type,
                    'reference_id' => $appeal->content_id,
                ])->first();

                $appeal->update([
                    'status' => 'approved',
                    'admin_id' => auth()->id(),
                    'admin_reason' => $request->reason,
                ]);

                $content->update([
                    'isDelete' => false
                ]);

                $content->user->detail->update([
                    'suspend_until' => null,
                    'trust_score' => $content->user->detail->trust_score -= $log->change
                ]);

                TrustScoreLog::create([
                    'user_id'=>$content->user->id,
                    'user_action_id'=>auth()->id(),
                    'change'=> -$log->change,
                    'reason'=> 'Your appeal is accept by admin',
                    'reference_type'=>$appeal->content_type,
                    'reference_id'=>$appeal->content_id,
                ]);

            } else if ($request->type == 'reject') {
                $appeal->update([
                    'status'=>'rejected',
                    'admin_id'=>auth()->id(),
                    'admin_reason'=>$request->reason
                ]);
            }
            
            $content->user->notify(new AppealsResult($appeal, $appeal->status, $content, $request->reason));

            DB::commit();

            return redirect()->route('admin-appeals')->with('alert', ['type' => 'success', 'message' => 'Success to action appeal']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('alert', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
