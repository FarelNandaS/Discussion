@extends('layout.default')
@section('title', 'Admin Reports')
@section('script')
  @vite(['resources/js/admin/reports.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">Reports</h3>
      </div>
      <div class="w-full">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <table id="reportsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Reported Username</th>
                  <th class="text-center">Reported Content</th>
                  <th class="text-center">Total Weight</th>
                  <th class="text-center">Total Reports</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reports as $report)
                  <?php
                  if ($report->reportable_type == \App\Models\Post::class) {
                      $content = \App\Models\Post::find($report->reportable_id);
                  } elseif ($report->reportable_type == \App\Models\Comment::class) {
                      $content = \App\Models\Comment::find($report->reportable_id);
                  }
                  ?>
                  <tr>
                    <td class="text-center"></td>
                    <td class="text-center">{{ $content->user->username }}</td>
                    <td class="text-center">{{ Str::limit($content->content, 50) }}</td>
                    <td class="text-end">{{ $report->weight_count }}</td>
                    <td class="text-end">{{ $report->report_count }}</td>
                    <td class="text-center">
                      @if ($report->reportable_type == \App\Models\Post::class)
                        <a href="{{ route('admin-reports-detail', ['type'=>'post', 'id'=>$report->reportable_id]) }}" class="tooltip tooltip-left" data-tip="Detail">
                          <x-tabler-eye style="width: 20px; height: 20px;" />
                        </a>
                      @elseif ($report->reportable_type == \App\Models\Comment::class)
                        <a href="{{ route('admin-reports-detail', ['type'=>'comment', 'id'=>$report->reportable_id]) }}" class="tooltip tooltip-left" data-tip="Detail">
                          <x-tabler-eye style="width: 20px; height: 20px;" />
                        </a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
