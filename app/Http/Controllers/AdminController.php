<?php

namespace App\Http\Controllers;

use App\Models\Appeals;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::count();
        $userLastMonth = User::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $userDiff = $totalUsers - $userLastMonth;

        $reportsCount = Report::where('status', 'pending')->count();

        $appealsCount = Appeals::where('status', 'pending')->count();

        $days = collect(range(29, 0))->map(function ($i) {
            return Carbon::now()->subDays($i)->format('Y-m-d');
        });
        $postTrafic = Post::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )->where('created_at', '>=', Carbon::now()->subDays(30))->groupBy('date')->get()->pluck('count', 'date');
        $chartLabels = [];
        $chartValues = [];

        foreach ($days as $date) {
            $chartLabels[] = Carbon::parse($date)->format('d M');
            $chartValues[] = $postTrafic->get($date, 0);
        }

        $urgentReports = Report::where('status', 'pending')->select(
            'reportable_type',
            'reportable_id',
            DB::raw('COUNT(*) as report_count'),
            DB::raw('SUM(weight) as weight_count'),
            DB::raw('MAX(created_at) as latest_report_at'),
        )->groupBy('reportable_type', 'reportable_id')->having('weight_count', '>=', 100)->orderByDesc('weight_count')->take(10)->get();

        return view('pages.admin.dashboard', [
            'totalUsers'=>$totalUsers,
            'userDiff'=>$userDiff,
            'reportsCount'=>$reportsCount,
            'appealsCount'=>$appealsCount,
            'chartLabels'=>$chartLabels,
            'chartValues'=>$chartValues,
            'urgentReports'=>$urgentReports,
        ]);
    }

    public function reports() {
        $reports = Report::where('status', 'pending')->select(
            'reportable_type',
            'reportable_id',
            DB::raw('COUNT(*) as report_count'),
            DB::raw('SUM(weight) as weight_count'),
            DB::raw('MAX(created_at) as latest_report_at'),
        )->groupBy('reportable_type', 'reportable_id')->having('weight_count', '>', 30)->orderByDesc('weight_count')->get();

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

    public function appeals() {
        $appeals = Appeals::where('status', 'pending')->orderByDesc('created_at')->get();

        return view('pages.admin.appeals', ['appeals'=>$appeals]);
    }

    public function appealDetail($id) {
        $appeal = Appeals::find($id);
        $reports = Report::where([
            'reportable_type'=>$appeal->content_type,
            'reportable_id'=>$appeal->content_id,
            'status'=>['actiond', 'dismiss']
        ])->get();

        return view('pages.admin.appealDetail', ['appeal'=>$appeal, 'reports'=>$reports]);
    }

    public function userManagement() {
        $users = User::whereNot('id', auth()->id())->get();

        return view('pages.admin.userManagement', compact('users'));
    }
}
