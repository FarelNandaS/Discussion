<nav class="navbar backdrop-blur-3xl sticky top-0 z-10">
  <div class="flex justify-between w-full bg-base-100 p-2 rounded shadow-lg border border-gray-500">
    <div class="flex items-center">
      <label for="drawer-sidebar" aria-label="open sidebar" class="lg:hidden">
        <x-tabler-menu-2 style="width: 30px;" />
      </label>
    </div>

    {{-- Search --}}
    <form class="flex items-center m-0 w-1/2 max-w-lg join" action="/search">
      <input type="text" name="key" placeholder="Search..." value="{{ $key ?? '' }}" class="input join-item">
      <button class="flex items-center join-item rounded justify-center p-2 bg-primary text-white tooltip tooltip-bottom" data-tip="Search">
        <x-tabler-search style="width: 20px"/>
      </button>
    </form>

    {{-- Profile/Login --}}
    <div class="flex justify-center items-center gap-4">
      @auth
        {{-- <li class="text-lg"><a href="{{ route('profile', ['username'=>auth()->user()->username]) }}" class="hover:underline">Profile</a></li> --}}
        <a href="" tabindex="0" class="btn btn-ghost btn-circle">
          <div class="w-9 rounded-full">
            <x-phosphor-bell style="width: 100%; height: 100%;"/>
          </div>
        </a>
        <a href="{{ route('profile', ['username'=>auth()->user()->username]) }}" tabindex="0" class="btn btn-ghost btn-circle avatar tooltip tooltip-bottom" data-tip="Profile">
          <div class="w-9 rounded-full">
            @if (auth()->user()->detail?->image)
              <img src="{{ asset('storage/profile/' . auth()->user()->detail->image) }}" alt="avatar" />
            @else
              <x-tabler-user-circle style="width: 100%; height: 100%; padding: 0;" />
            @endif
          </div>
        </a>
      @else
        <div class="text-lg"><a href="/login" class="hover:underline">Login</a></div>
      @endauth
    </div>
  </div>
</nav>
