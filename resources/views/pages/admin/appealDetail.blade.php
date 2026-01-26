@extends('layout.default')
@section('title', 'Admin appeal detail')
@section('script')
  @vite(['resources/js/admin/appealDetail.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="w-full flex flex-wrap gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">Appeal</h3>
      </div>
      <div class="w-full mb-4">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <div class="grid grid-cols-4 gap-4">
              <div class="mb-4 col-span-4">
                <h3 class="text-2xl font-bold">Details</h3>
              </div>
              <div class="col-span-2 mb-4">
                <p class="text-lg font-bold mb-2">Content Type</p>
                <p class="text-base">{{ $appeal->content_type == \App\Models\Post::class ? 'Post' : 'Comment' }}</p>
              </div>
              <div class="col-span-2 mb-4">
                <p class="text-lg font-bold mb-2">Username</p>
                <p class="text-base">{{ $appeal->user->username }}</p>
              </div>
              <div class="col-span-2 mb-4">
                <p class="text-lg font-bold mb-2">User trust score</p>
                <p class="text-base">{{ $appeal->user->detail->trust_score }}</p>
              </div>
              <div class="col-span-2 mb-4">
                <p class="text-lg font-bold mb-2">User posts count</p>
                <p class="text-base">{{ $appeal->user->posts->count() }}</p>
              </div>
              <div class="col-span-2 mb-4">
                <p class="text-lg font-bold mb-2">Number of report in this content</p>
                <p class="text-base">{{ $reports->count() }}</p>
              </div>
              <div class="col-span-4 mb-4">
                <p class="text-lg font-bold mb-2">User Message</p>
                <p class="text-base">{{ $appeal->message }}</p>
              </div>
              @if ($appeal->content_type == \App\Models\Post::class)
                <div class="col-span-4 mb-4">
                  <p class="text-lg font-bold mb-2">The Title</p>
                  <p class="text-base">{{ $appeal->content->title }}</p>
                </div>
              @endif
              <div class="col-span-4 mb-4">
                <p class="text-lg font-bold mb-2">The Content</p>
                <p class="text-base">{{ $appeal->content->content }}</p>
              </div>
              <div class="col-span-4 mb-4 flex justify-end items-center gap-2">
                <button class="btn btn-success" onclick="showModal('accept')">Accept</button>
                <button class="btn btn-error" onclick="showModal('reject')">Reject</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="w-full mb-4">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <h3 class="text-2xl font-bold">Historical Report Reference</h3>
            <table id="reportsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Reporter Username</th>
                  <th class="text-center">Reason Type</th>
                  <th class="text-center">Message</th>
                  <th class="text-center">Weight</th>
                  <th class="text-center">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reports as $report)
                  <tr>
                    <td class="text-center"></td>
                    <td class="text-center">{{ $report->reporter->username }}</td>
                    <td class="text-center">{{ $report->reason_type }}</td>
                    <td class="text-center">{{ $report->message ?? '-' }}</td>
                    <td class="text-center">{{ $report->weight }}</td>
                    <td class="text-center">{{ $report->status }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <dialog id="modalAction" class="modal">
    <div class="modal-box flex flex-col gap-4 border border-gray-500">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>

      <form id="formAction" action="{{ route('admin-appeal-actiond') }}" method="POST">
        @csrf
        <input type="hidden" name="type" id="action_type" value="">
        <input type="hidden" name="id" value="{{ $appeal->id }}">
        <h5 class="text-xl font-bold mb-4">Appeal Action</h5>
        <div class="w-full flex flex-col mb-4">
          <label for="acceptReason" class="mb-2">Reason</label>
          <textarea type="text" id="acceptReason" name="reason" class="textarea w-full" placeholder="Enter your reason"
            required></textarea>
        </div>
        <div class="w-full flex mb-4 justify-end items-center">
          <button type="button" class="btn btn-primary" onclick="validate()">Submit</button>
        </div>
      </form>
    </div>

    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </dialog>

  <script>
    function showModal(type) {
      $('input[name="type"]').val(type);
      modalAction.showModal();
    }

    function validate() {
      const reason = $('textarea[name="reason"]').val();

      if (reason == '') {
        showAlert('warning', 'Reason is required')
      } else {
        $('#formAction').submit();
      }
    }
  </script>
@endsection
