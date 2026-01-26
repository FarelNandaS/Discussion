@extends('layout.default')
@section('title', 'Admin Dashboard')
@section('script')
  @vite(['resources/js/admin/dashboard.js'])
@endsection
@section('main')
  <div class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
      <div class="col-span-4 md:col-span-1 card shadow-lg bg-base-100 border border-gray-500">
        <div class="card-body p-0">
          <div class="stat">
            <div class="stat-figure">
              <x-heroicon-o-user-group class="w-12 h-12" />
            </div>
            <div class="stat-title">
              Total Members
            </div>
            <div class="stat-value">
              {{ $totalUsers }}
            </div>
            <div class="stat-desc">
              {{ $userDiff }} more than last month
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-4 md:col-span-1 card shadow-lg bg-base-100 border border-gray-500">
        <div class="card-body p-0">
          <div class="stat">
            <div class="stat-figure">
              <x-tabler-report-analytics class="w-12 h-12" />
            </div>
            <div class="stat-title">
              Pending Reports
            </div>
            <div class="stat-value">
              {{ $reportsCount }}
            </div>
            <div class="stat-desc">
              Unresolved issues
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-4 md:col-span-1 card shadow-lg bg-base-100 border border-gray-500">
        <div class="card-body p-0">
          <div class="stat">
            <div class="stat-figure">
              <x-tabler-gavel class="w-12 h-12" />
            </div>
            <div class="stat-title">
              Open Appeals
            </div>
            <div class="stat-value">
              {{ $appealsCount }}
            </div>
            <div class="stat-desc">
              Users waiting for response
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-4 md:col-span-2 card shadow-lg bg-base-100 border border-gray-500">
        <div class="card-body">
          <div class="flex justify-between items-center mb-4">
            <div>
              <h2 class="card-title text-lg font-bold">Post Traffic</h2>
              <p class="text-sm opacity-50">User posting activity</p>
            </div>
            <div class="badge badge-primary font-bold">Last 30 days</div>
          </div>

          <div id="post_traffic_chart" data-labels="{{ json_encode($chartLabels) }}"
            data-values="{{ json_encode($chartValues) }}">
          </div>
        </div>
      </div>
      <div class="col-span-4 md:col-span-1 card shadow-lg bg-base-100 border border-gray-500">
        <div class="card-body p-4">
          <div class="flex items-center justify-between mb-4">
            <h2 class="card-title text-lg font-bold flex items-center gap-2">
              Urgent Reports
            </h2>
            <span class="badge badge-primary badge-sm text-white font-bold">{{ count($urgentReports) }}</span>
          </div>

          <div class="flex flex-col gap-3">
            @forelse ($urgentReports as $report)
              @php
                $content =
                    $report->reportable_type == \App\Models\Post::class
                        ? \App\Models\Post::find($report->reportable_id)
                        : \App\Models\Comment::find($report->reportable_id);
              @endphp

              <a href="{{ $report->reportable_type == \App\Models\Post::class ? route('admin-reports-detail', ['type'=>'post', 'id'=>$report->reportable_id]) : route('admin-reports-detail', ['type'=>'comment', 'id'=>$report->reportable_id]) }}"
                class="group flex flex-col p-3 border border-gray-600 shadow-lg rounded-xl hover:bg-base-200 transition-all cursor-pointer relative overflow-hidden">

                <div class="flex justify-between items-start mb-1">
                  <div class="flex items-center gap-2">
                    <div class="avatar">
                      <div class="w-6 rounded-full">
                        @if ($content->user->detail?->image)
                          <img src="{{ asset('storage/profile/' . auth()->user()->detail->image) }}" alt="avatar" />
                        @else
                          <x-phosphor-user-circle style="width: 100%; height: 100%; padding: 0;" />
                        @endif
                      </div>
                    </div>
                    <span class="text-xs font-bold">{{ $content->user->username }}</span>
                  </div>
                  <div class="badge badge-ghost badge-xs text-[10px] uppercase font-black tracking-wider">
                    {{ $report->weight_count }}
                  </div>
                </div>

                <p class="text-sm font-medium line-clamp-1 mb-1">
                  {{ \Illuminate\Support\Str::limit($content->title ?? $content->content, 40) }}
                </p>

                <div class="flex justify-between items-center mt-1">
                  <span class="text-[10px] opacity-60 flex items-center gap-1">
                    <x-heroicon-o-clock class="w-3 h-3" />
                    {{ \Carbon\Carbon::parse($report->latest_report_at)->diffForHumans() }}
                  </span>
                </div>
              </a>
            @empty
              <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                <x-phosphor-check-circle class="w-12 h-12 mb-2 opacity-20" />
                <p class="text-xs italic">No urgent issues found</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
