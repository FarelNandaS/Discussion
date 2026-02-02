<nav class="navbar backdrop-blur-3xl sticky top-0 z-10">
  <div class="flex justify-between w-full bg-base-100 p-2 rounded shadow-lg border border-gray-500">
    <div class="flex items-center">
      <label for="drawer-sidebar" aria-label="open sidebar" class="lg:hidden">
        <x-tabler-menu-2 style="width: 30px;" />
      </label>
    </div>

    {{-- Search --}}
    <form class="flex items-center m-0 w-1/2 max-w-lg join" action="/search">
      <input type="text" name="key" placeholder="Search by title, username, content, or tag..." value="{{ $key ?? '' }}" class="input join-item">
      <button
        class="flex items-center join-item rounded justify-center p-2 bg-primary text-white tooltip tooltip-bottom"
        data-tip="Search">
        <x-tabler-search style="width: 20px" />
      </button>
    </form>

    {{-- Profile/Login --}}
    <div class="flex justify-center items-center px-4 gap-2">
      @auth
        <?php
        $haveNew = auth()->user()->unreadNotifications;
        $latestNotif = auth()->user()->notifications()->latest()->limit(3)->get();
        ?>

        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="btn btn-ghost btn-circle indicator"
            style="width: 25px; height: 25px;">
            {{-- Titik Notifikasi (Badge) --}}
            @if ($haveNew->count() > 0)
              <span class="indicator-item status status-error"></span>
            @endif
            <div class="w-9 rounded-full flex items-center justify-center">
              <x-phosphor-bell style="width: 100%; height: 100%;" />
            </div>
          </div>

          {{-- Konten Dropdown --}}
          <div tabindex="0"
            class="mt-3 z-1 card card-compact dropdown-content w-72 bg-base-100 shadow-xl border border-gray-500">
            <div class="card-body">
              <h3 class="font-bold text-lg m-0">Notifications</h3>

              <div class="flex flex-col">
                @if ($latestNotif->count() > 0)
                  @foreach ($latestNotif as $notif)
                    <a href="{{ route('inbox-detail', ['id' => $notif->id]) }}"
                      class="flex items-start gap-2 text-sm hover:bg-base-200 p-2 rounded-lg cursor-pointer">
                      @if (!$notif->read_at)
                        <div class="w-2 h-2 mt-1.5 bg-primary rounded-full shrink-0"></div>
                      @else
                        <div class="w-2 h-2 mt-1.5 bg-base-content/60 rounded-full shrink-0"></div>
                      @endif
                      <p>{{ \Illuminate\Support\Str::limit($notif->data['title'], 30) }}</p>
                    </a>
                  @endforeach
                @else
                  <div class="w-full flex text-center my-2">
                    <p class="text-base-content/60">Your inbox is still empty.</p>
                  </div>
                @endif
              </div>

              <div class="card-actions">
                <a href="{{ route('inbox') }}" class="btn btn-primary btn-sm btn-block">Lihat Semua</a>
              </div>
            </div>
          </div>
        </div>
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar">
            <div class="w-9 rounded-full">
              @if (auth()->user()->detail?->image)
                <img src="{{ asset('storage/profile/' . auth()->user()->detail->image) }}" alt="avatar" />
              @else
                <x-phosphor-user-circle style="width: 100%; height: 100%; padding: 0;" />
              @endif
            </div>
          </label>
          <ul tabindex="0"
            class="menu dropdown-content mt-3 z-1 p-2 shadow-xl bg-base-100 rounded-box w-52 border border-gray-500">
            <li>
              <a href="{{ route('profile', ['username' => auth()->user()->username]) }}">
                <x-tabler-user-circle style="width: 25px; height: 25px;" />
                My Profile
              </a>
            </li>
            @if (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Super Admin'))
              <li>
                <a href="{{ route('admin-dashboard') }}">
                  <x-tabler-layout-dashboard style="width: 25px; height: 25px;" />
                  Dashboard
                </a>
              </li>
            @endif
            <li>
              <form method="POST" action="{{ route('logout-attempt') }}" class="flex">
                @csrf
                <button type="submit" class="min-w-full text-left flex gap-2">
                  <x-tabler-logout style="width: 25px; height: 25px;" />
                  Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
        {{-- <a href="{{ route('profile', ['username' => auth()->user()->username]) }}" tabindex="0"
          class="btn btn-ghost btn-circle avatar tooltip tooltip-bottom" data-tip="Profile">
          <div class="w-9 rounded-full">
            @if (auth()->user()->detail?->image)
              <img src="{{ asset('storage/profile/' . auth()->user()->detail->image) }}" alt="avatar" />
            @else
              <x-tabler-user-circle style="width: 100%; height: 100%; padding: 0;" />
            @endif
          </div>
        </a> --}}
      @else
        <div class="text-lg"><a href="/login" class="hover:underline font-semibold">Login</a></div>
      @endauth
    </div>
  </div>
</nav>
