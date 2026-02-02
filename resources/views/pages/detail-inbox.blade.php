@extends('layout.default')
@section('title', 'Detail Indox')
@section('main')
  <?php
  $appeal = \App\Models\Appeals::where('notification_id', $notification->id)->first();
  $haveAppeal = $appeal?->exists() ?? false;
  ?>

  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full">
        <h3 class="text-2xl font-bold mb-4">Detail notification</h3>
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <h5 class="text-xl font-bold">
              {{ $notification->data['title'] }}
            </h5>
            <p>{{ $notification->data['message'] ?? '' }}</p>
            <div class="flex w-full mt-4">
              @if (($notification->data['isAppealable'] ?? false) && !$haveAppeal)
                <button class="btn btn-primary" onclick="modalAppeal.showModal()">Request Appeal</button>
              @elseif ($haveAppeal && $appeal->status == 'pending')
                <div class="alert alert-warning shadow-sm">
                  <x-phosphor-warning style="width: 25px; height: 25px;" />
                  <div class="flex flex-col">
                    <span class="font-bold">Appeal Under Review</span>
                    <span class="text-sm">We are currently reviewing your appeal. Please wait for further
                      information.</span>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  @if (($notification->data['isAppealable'] ?? false) && !$haveAppeal)
    <dialog id="modalAppeal" class="modal">
      <div class="modal-box flex flex-col gap-4 border border-gray-500">
        <form method="dialog">
          <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <form id="formAppeal" action="{{ route('appeal-submit') }}" method="POST">
          @csrf
          <input type="hidden" name="notification_id" value="{{ $notification->id }}">
          <input type="hidden" name="content_id" value="{{ $notification->data['content_id'] }}">
          <input type="hidden" name="content_type" value="{{ $notification->data['content_type'] }}">
          <h5 class="text-xl font-bold mb-4">Submit Appeal</h5>
          <div class="w-full flex flex-col mb-4">
            <label for="appealMessage" class="mb-2">Message</label>
            <textarea type="text" id="appealMessage" name="message" class="textarea w-full" placeholder="Enter your message"
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
  @endif


  <script>
    function validate() {
      const message = $('#appealMessage').val();

      if (message == '') {
        showAlert('warning', 'Message is required')
      } else {
        $('#formAppeal').submit();
      }
    }
  </script>
@endsection
