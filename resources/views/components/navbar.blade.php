<nav class="navbar flex px-4 justify-between sticky top-0 bg-base-100 z-10 border-b border-gray-500">
  <div class="flex-none">
    <label for="drawer-sidebar" aria-label="open sidebar" class="lg:hidden">
      <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            class="inline-block h-6 w-6 stroke-current"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
    </label>
  </div>

  {{-- Search --}}
  <form class="flex items-center m-0 w-1/2 max-w-lg join" action="/search">
    <input type="text" 
           name="key"
           placeholder="Search..." 
           value="{{ $key ?? '' }}"
           class="input join-item">
    <button class="flex items-center justify-center p-2 rounded bg-neutral">
      {!! file_get_contents(public_path('images/search.svg')) !!}
    </button>
  </form>

  {{-- Profile/Login --}}
  <ul class="flex-none gap-4">
    @auth
      <li class="text-lg"><a href="{{ route('profile', ['username'=>auth()->user()->username]) }}" class="hover:underline">Profile</a></li>
    @else
      <li class="text-lg"><a href="/login" class="hover:underline">Login</a></li>
    @endauth
  </ul>
</nav>
