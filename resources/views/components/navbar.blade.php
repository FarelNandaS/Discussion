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
  </ul>
</nav>
