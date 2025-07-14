<div x-cloak x-show="$store.confirmDialog.open"
  class="fixed w-screen h-screen justify-center items-center z-50 bg-black bg-opacity-70 flex">
  <div class="flex flex-col items-center border border-gray-500 rounded p-4 bg-ccblack gap-4 w-4/12" x-transition x-cloak
    x-show="$store.confirmDialog.open">
    <img src="/images/warning.svg" alt="warning" width="100">
    <h1 class="text-4xl font-bold">Are you sure?</h1>
    <p x-text="$store.confirmDialog.message" class="text-xl">You won't be able to revert this!</p>
    <div class="flex justify-between gap-4">
      <button x-on:click="$store.confirmDialog.confirmAction()" x-text="$store.confirmDialog.btnText"
        class="bg-green-500 p-2 rounded text-xl">Yes, Delete it!</button>
      <button x-on:click="$store.confirmDialog.open = false" class="bg-red-500 p-2 rounded text-xl">Cancel</button>
    </div>
  </div>
</div>
