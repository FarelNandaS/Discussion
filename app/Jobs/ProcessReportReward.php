<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Report;
use App\Models\TrustScoreLog;
use App\Models\UserDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProcessReportReward implements ShouldQueue
{
    use Queueable;

    protected $isValid;
    protected $reportableType;
    protected $reportableId;
    protected $adminId;

    /**
     * Create a new job instance.
     */
    public function __construct($isValid, $type, $id, $adminId)
    {
        $this->isValid = $isValid;
        $this->reportableType = $type;
        $this->reportableId = $id;
        $this->adminId = $adminId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $content = null;

            if ($this->reportableType == Post::class) {
                $content = Post::find($this->reportableId);
            }

            $reporterIds = Report::where('reportable_type', $this->reportableType)->where('reportable_id', $this->reportableId)->pluck('reporter_id')->unique();

            // if ($reporterIds->isEmpty()) {
            //     return;
            // }

            $change = $this->isValid ? 5 : -5;

            $title = $content ? ($content->title ?? $content->content) : 'Unknown Content';

            $reasonLog = $this->isValid
                ? 'The report you provided in the content "' . Str::limit($title, 30) . '" has been validated by the admin'
                : 'The report you provided in the content "' . Str::limit($title, 30) . '" is invalid according to the admin';

            UserDetail::whereIn('user_id', $reporterIds)->update([
                'trust_score' => DB::raw("LEAST(100, GREATEST(0, trust_score + ($change)))"),
                'suspend_until' => DB::raw("
                    CASE WHEN (trust_score + ($change)) < 70 THEN '" . now()->addDays(7)->toDateTimeString() . "'
                    ELSE NULL
                    END
                "),
                'updated_at' => now()
            ]);

            $logs = [];
            foreach ($reporterIds as $id) {
                $logs[] = [
                    'user_id' => $id,
                    'user_action_id' => $this->adminId,
                    'change' => $change,
                    'reason' => $reasonLog,
                    'reference_type' => $this->reportableType,
                    'reference_id' => $this->reportableId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            TrustScoreLog::insert($logs);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
