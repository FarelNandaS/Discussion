<div id="confirmDialog"
  class="fixed w-screen h-screen justify-center items-center z-50 bg-black bg-opacity-70 hidden">
  <div class="flex flex-col items-center border border-gray-500 rounded p-4 bg-ccblack gap-4 w-4/12">
    <img src="/images/warning.svg" alt="warning" width="100">
    <h1 class="text-4xl font-bold">Are you sure?</h1>
    <p id="confirm-popup" class="text-xl">You won't be able to revert this!</p>
    <div class="flex justify-between gap-4">
      <button id="okBtn" class="bg-green-500 p-2 rounded text-xl">Yes, Delete it!</button>
      <button class="bg-red-500 p-2 rounded text-xl" onclick="closeConfirm()">Cencel</button>
    </div>
  </div>
</div>

<script>
  let confirmCallback = null;

  function showConfirm(callback, message, btnText) {
    document.getElementById('confirm-popup').innerHTML = message;
    document.getElementById('okBtn').innerHTML = btnText;
    document.getElementById('confirmDialog').classList.remove('hidden');
    document.getElementById('confirmDialog').classList.add('flex');
    confirmCallback = callback;
  }

  function closeConfirm() {
    document.getElementById('confirmDialog').classList.remove('flex');
    document.getElementById('confirmDialog').classList.add('hidden');
    confirmCallback = null
  }

  document.getElementById('okBtn').addEventListener('click', () => {
    if (confirmCallback) confirmCallback();
    closeConfirm();
  })
</script>
