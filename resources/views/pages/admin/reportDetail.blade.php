@extends('layout.default')
@section('title', 'Admin Reports Content')
@section('script')
  @vite(['resources/js/admin/reportDetail.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">Report</h3>
      </div>
      <div class="w-full mb-4">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="mb-4 col-span-2">
                <h3 class="text-2xl font-bold">Details</h3>
              </div>

              <div class="mb-4">
                <p class="text-lg font-bold mb-2">Type</p>
                <p class="text-base">{{ $type }}</p>
              </div>
              <div class="mb-4">
                <p class="text-lg font-bold mb-2">Username</p>
                <p class="text-base">{{ $content->user->username }}</p>
              </div>
              <div class="mb-4">
                <p class="text-lg font-bold mb-2">User Trust Score</p>
                <p class="text-base">{{ $content->user->detail->trust_score }}</p>
              </div>
              <div class="mb-4">
                <p class="text-lg font-bold mb-2">User Posts Count</p>
                <p class="text-base">{{ $content->user->posts->count() }}</p>
              </div>

              @if ($type == 'post')
                <div class="mb-4 col-span-2">
                  <p class="text-lg font-bold mb-2">The Title</p>
                  <p class="text-base">{{ $content->title }}</p>
                </div>
              @endif

              <div class="mb-4 col-span-2">
                <p class="text-lg font-bold mb-2">The Content</p>
                <p class="text-base whitespace-pre-line">{{ $content->content }}</p>
              </div>

              <div class="mb-4 col-span-2 flex justify-end items-center gap-4">
                <button class="btn btn-success" onclick="modalActionReport.showModal()">Give Suspend</button>
                <button class="btn btn-error" onclick="clickDismiss()">Dismiss</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <h3 class="text-2xl font-bold">Reports</h3>
            <table id="reportsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Reporter Username</th>
                  <th class="text-center">Reason Type</th>
                  <th class="text-center">Message</th>
                  <th class="text-center">Weight</th>
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
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <dialog id="modalActionReport" class="modal">
    <div class="modal-box border border-gray-500">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <form id="formActionSuspend" action="{{ route('admin-report-action-suspend') }}" method="POST" class="w-full flex flex-wrap">
        @csrf
        <input type="hidden" name="reportable_type" value="{{ $content->getMorphClass() }}">
        <input type="hidden" name="reportable_id" value="{{ $content->id }}">
        <h5 class="w-full my-4 text-xl font-bold">Give suspend</h5>
        <div class="mb-4 w-full flex flex-col">
          <label for="suspend_until" class="mb-2">Suspend until</label>
          <input type="datetime-local" id="suspend_until" name="suspend_until" class="input w-full" placeholder="Enter suspend time" min="0" max="100" required>
        </div>
        <div class="mb-4 w-full flex flex-col">
          <label for="change" class="mb-2">Penalty point</label>
          <input type="number" id="change" name="change" class="input w-full" placeholder="Enter the minus trust score" min="0" max="100" required>
        </div>
        <div class="mb-4 w-full flex flex-col">
          <label for="reason" class="mb-2">Reason</label>
          <textarea rows="3" maxlength="255" type="text" id="reason" name="reason" class="textarea w-full" placeholder="Enter reason" required></textarea>
        </div>
        <div class="mb-4 w-full flex justify-end items-center">
          <button type="button" class="btn btn-primary" onclick="validate()">Submit</button>
        </div>
      </form>
    </div>
    <form method="dialog" class="modal-backdrop">
      <button>close</button>
    </form>
  </dialog>

  <form id="formActionDismiss" action="{{ route('admin-report-action-dismiss') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="reportable_type" value="{{ $content->getMorphClass() }}">
    <input type="hidden" name="reportable_id" value="{{ $content->id }}">
  </form>

  <script>
    function sendForm() {
      $('#formActionSuspend').submit();
    }

    function validate() {
      let date = $('input[name="suspend_until"]').val();
      let change = $('input[name="change"]').val();
      let reason = $('textarea[name="reason"]').val();

      if (date == '') {
        showAlert('warning', 'suspend date is required');
      } else if (change == '') {
        showAlert('warning', 'penalty score is required');
      } else if (change <= 0 || change >= 100) {
        showAlert('warning', 'penalty score is must between 0 to 100')
      } else if (reason == '') {
        showAlert('warning', 'reason is required');
      } else {
        showConfirm(sendForm, 'Are you sure to give suspend to this user', 'yes, sure')
      }
    }

    function clickDismiss() {
      showConfirm(function () {
        $('#formActionDismiss').submit();
      }, 'Are you sure to dismiss this reports', 'yes, sure')
    }
  </script>
@endsection
