@extends('layout.default')
@section('title', 'Admin appeals')
@section('script')
  @vite(['resources/js/admin/appeals.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">Appeals</h3>
      </div>
      <div class="w-full">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <table id="appealsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Username</th>
                  <th class="text-center">Content/Title</th>
                  <th class="text-center">User message</th>
                  <th class="text-center">User weight</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($appeals as $appeal)
                  <tr>
                    <td class="text-center"></td>
                    <td class="text-center">{{ $appeal->user->username }}</td>
                    <td class="text-center">
                      {{ \Illuminate\Support\Str::limit($appeal->content->title ?? $appeal->content->content, 50) }}</td>
                    <td class="text-center">
                      {{ \Illuminate\Support\Str::limit($appeal->message, 50) }}
                    </td>
                    <td class="text-end">{{ $appeal->user->detail->trust_score }}</td>
                    <td class="text-center">
                      <a href="{{ route('admin-appeals-detail', ['id' => $appeal->id]) }}" class="tooltip tooltip-left"
                        data-tip="Detail">
                        <x-tabler-eye style="width: 20px; height: 20px;" />
                      </a>
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
