<div class="h-[60px] top-0 left-0 flex justify-between items-center p-4 px-8">
  <form class="flex justify-center items-center gap-2 m-0" action="/search">
    <input type="text" placeholder="Search..." class="p-2 rounded bg-ccblack w-[50vw]" name="key" @if (isset($key))
    value="{{$key}}"
    @endif>
    <button class="flex justify-center items-center text-ccwhite bg-ccblack p-[10px] rounded"><img
        src="/Images/search.svg" alt="search" width="20px" height="20px"></button>
  </form>
  <ul class="flex gap-4">
    @if (auth()->check())
      <li class="text-lg font-sans"><a href="/{{ auth()->user()->username }}" class="">Profile</a></li>
    @else
      <li class="text-lg font-sans"><a href="/login">Login</a></li>
    @endif
  </ul>
</div>
