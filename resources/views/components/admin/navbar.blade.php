<nav class="navbar backdrop-blur-3xl sticky top-0 z-10">
  <div class="flex justify-between w-full bg-base-100 p-2 rounded shadow-lg border border-gray-500">
    <div class="flex items-center gap-3">
      <label for="drawer-sidebar" aria-label="open sidebar" class="lg:hidden">
        <x-tabler-menu-2 style="width: 30px;"/>
      </label>
      <span class="">
        {{ now()->isoFormat('dddd, D MMMM YYYY') }}
      </span>
    </div>
  
    <div class="flex items-center gap-4">
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-9 rounded-full">
            @if (auth()->user()->detail?->image)
              <img src="{{ asset('storage/profile/' . auth()->user()->detail->image) }}" alt="avatar" />
            @else
              <x-tabler-user-circle style="width: 100%; height: 100%; padding: 0;"/>
            @endif
          </div>
        </label>
        <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
          <li>
            <a href="{{ route('admin-profile', ['username' => auth()->user()->username]) }}">
              <x-tabler-user-circle style="width: 40px;"/>
              My Profile
            </a>
          </li>
          <li>
            <form method="POST" action="{{ route('logout-attempt') }}">
              @csrf
              <button type="submit" class="w-full text-left flex gap-2">
                <x-tabler-logout style="width: 40px;"/>
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>