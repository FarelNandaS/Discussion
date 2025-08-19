<<<<<<< HEAD
<nav class="h-[60px] p-4 flex justify-between items-center px-8 bg-primary text-white">
  <div></div>

  {{-- Search --}}
  <form class="flex items-center gap-2 m-0 w-1/2 max-w-lg" action="/search">
    <input type="text" 
           name="key"
           placeholder="Search..." 
           value="{{ $key ?? '' }}"
           class="p-2 rounded w-full bg-ccblack text-white outline-none focus:ring-2 focus:ring-white">
    <button class="flex items-center justify-center bg-ccblack p-2 rounded">
      <img src="/Images/search.svg" alt="search" width="20" height="20">
    </button>
  </form>

  {{-- Profile/Login --}}
  <ul class="flex gap-4">
    @auth
      <li class="text-lg"><a href="/{{ auth()->user()->username }}" class="hover:underline">Profile</a></li>
    @else
      <li class="text-lg"><a href="/login" class="hover:underline">Login</a></li>
    @endauth
=======
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
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
  </ul>
</nav>
