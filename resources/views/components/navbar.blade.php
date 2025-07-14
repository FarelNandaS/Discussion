<div class="h-[60px] top-0 left-0 flex justify-between items-center p-4 px-8 bg-primary">
  <form class="flex justify-center items-center gap-2 m-0" action="/search">
    <input type="text" placeholder="Search..." class="p-2 rounded bg-gray-50 placeholder-black text-ccblack dark:placeholder-white dark:text-white dark:bg-ccblack w-[50vw]" name="key"
      @if (isset($key)) value="{{ $key }}" @endif>
    <button class="flex justify-center items-center bg-ccwhite dark:text-ccwhite dark:bg-ccblack p-[10px] rounded">
      @include('icon.search')
    </button>
  </form>
  <ul class="flex gap-4">
    @if (auth()->check())
      <li class="text-lg font-sans"><a href="/{{ auth()->user()->username }}" class="">Profile</a></li>
    @else
      <li class="text-lg font-sans"><a href="/login">Login</a></li>
    @endif
  </ul>
</div>
