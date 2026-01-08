<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $reportsCount = Report::where('status', 'pending')->get()->count();

        return view('pages.admin.dashboard', ['reportsCount'=>$reportsCount]);
    }

    public function reports() {
        $reports = Report::where('status', 'pending')->select(
            'reportable_type',
            'reportable_id',
            DB::raw('COUNT(*) as report_count'),
            DB::raw('SUM(weight) as weight_count'),
            DB::raw('MAX(created_at) as latest_report_at'),
        )->groupBy('reportable_type', 'reportable_id')->having('weight_count', '>', 30)->orderByDesc('latest_report_at')->get();

        return view('pages.admin.reports', ['reports'=>$reports]);
    }

    public function reportDetail($type, $id) {
        if ($type == 'post') {
            $typeClass = Post::class;
        } else if ($type == 'comment') {
            $typeClass = Comment::class;
        }

        $reports = Report::where([
            'status'=>'pending',
            'reportable_type' => $typeClass,
            'reportable_id' => $id
        ])->orderByDesc('created_at')->get();

        if ($type == 'post') {
            $content = Post::find($id);
        } else if ($type == 'comment') {
            $content = Comment::find($id);
        }

        return view('pages.admin.reportDetail', ['reports'=>$reports, 'content'=>$content, 'type'=>$type]);
    }
}
