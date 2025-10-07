<dialog id="confirmDialog" class="modal">
  <div class="modal-box flex flex-col items-center gap-4">
    {!! file_get_contents(public_path('images/warning.svg')) !!}
    <h1 class="text-4xl font-bold">Are you sure?</h1>
    <p id="confirm-popup" class="text-xl"></p>

    <div class="modal-action flex justify-between gap-4">
      <button id="okBtn" class="btn btn-success text-xl" onclick="confirm()">Yes, Delete it!</button>
      <form method="dialog">
        <button class="btn btn-error text-xl">Cancel</button>
      </form>
    </div>
  </div>
</dialog>

<script>
  let confirmCallback = null;

  function showConfirm(callback, message, btnText) {
    $('#confirm-popup').text(message);
    $('#okBtn').text(btnText);
    confirmDialog.showModal();
    confirmCallback = callback;
  }

  function confirm() {
    if (confirmCallback) confirmCallback();
    closeConfirm();
  }

  function closeConfirm() {
    confirmDialog.close();
    confirmCallback = null
  }
</script>
