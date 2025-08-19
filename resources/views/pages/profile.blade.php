@extends('layout.default')
@section('title', $user?->username)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="w-full flex justify-between border-b border-gray-600 py-4">
      <div class="flex flex-col gap-4">
        <div class="flex w-full justify-between">
          <h1 class="text-2xl flex items-center gap-4">
            @if (isset($user->image))
              <img src="/assets/profile/{{ $user->image }}" alt="profile image" width="100" height="100"
                class="rounded-full">
            @else
              <img src="/assets/profile/default.svg" alt="profile image" width="100" height="100"
                class="rounded-full">
            @endif
            {{ $user->username }}
            @if ($user->role == 'admin')
              <img src="/images/admin.svg" alt="admin" width="30">
            @endif
          </h1>
        </div>
        <div class="flex flex-col">
          <p>{{ $user->gender }}</p>
          <p>{{ $user->info }}</p>
        </div>
        @livewire('follow-count', ['user' => $user])
      </div>

      @if (auth()->check())
        <div class="flex gap-2 items-start justify-center h-9">
          <div class="relative h-full w-full flex items-center">
            <button id="btn-dropdown-profile"
              class="border border-gray-500 rounded-full h-full w-9 flex items-center justify-center hover:bg-gray-500 hover:transition-all hover:duration-150" onclick="return showDropdown('profile')">
              <img src="/images/menu.svg" alt="menu" width="30">
            </button>
            <div id="dropdown-menu-profile"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex-col w-48 shadow-aroundShadow hidden">
              @if (auth()->user()->id == $user->id)
                <a href="/profile/edit"
                  class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 w-full flex items-center gap-2"><img
                    src="/images/edit.svg" alt="edit" width="25">Edit</a>
                <form id="logout-form-{{ $user->id }}" action="/logout" method="post" class="flex w-full m-0"
                  onsubmit="confirmLogout({{ $user->id }})">
                  @csrf
                  <button type="submit"
                    class="p-2 flex hover:bg-gray-500 hover:transition-all hover:duration-150 w-full gap-2"><img
                      src="/images/logout.svg" alt="logout" width="20">Logout</button>
                </form>
              @else
                @if (auth()->user()->role == 'admin')
                  @if ($user->role == 'user')
                    <form id="give-access-form-{{ $user->id }}" action="/give-access/{{ $user->id }}"
                      method="POST" class="flex items-center m-0"
                      onsubmit="return confirmGiveAccess({{ $user->id }})">
                      @csrf
                      <button
                        class="flex items-center w-full gap-2 p-2 hover:bg-gray-500 hover:transition-all hover:duration-150"><img
                          src="/images/admin.svg" alt="admin" width="25">Give admin access</button>
                    </form>
                  @else
                    <form id="delete-access-form-{{ $user->id }}" action="/delete-access/{{ $user->id }}"
                      method="POST" class="flex w-full items-center m-0"
                      onsubmit="return confirmDeleteAccess({{ $user->id }})">
                      @csrf
                      <button type="submit"
                        class="flex items-center w-full gap-2 p-2 hover:bg-gray-500 hover:transition-all hover:duration-150"><img
                          src="/images/admin.svg" alt="admin" width="25">Delete admin access</button>
                    </form>
                  @endif
                @endif
                <a href=""
                  class="p-2 hover:bg-gray-500 hover:transition-all hover:duration-150 flex gap-2 items-center"><img
                    src="/images/report.svg" alt="report" width="25">Laporkan {{ $user->username }}</a>
              @endif
            </div>
          </div>
          @if (auth()->user()->id != $user->id)
            @livewire('follow-button', ['user' => $user])
          @endif
        </div>
      @endif

    </div>
    @livewire('profile-content', [
        'username' => $user->username,
    ])
  </main>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', () => {
    function confirmLogout(id) {
      event.preventDefault();
      return showConfirm(function() {
        document.getElementById("logout-form-" + id).submit();
      }, "you can log back into this account", "Yes, logout from this account")
    }

    function confirmGiveAccess(id) {
      event.preventDefault();
      return showConfirm(function() {
        document.getElementById("give-access-form-" + id).submit();
      }, "Are you sure about giving this account admin access", "Yes, give admin access")
    }

    function confirmDeleteAccess(id) {
      event.preventDefault();
      return showConfirm(function() {
        document.getElementById("delete-access-form-" + id).submit();
      }, "You can grant access to this account again", "Yes, remove admin access")
    }
  })
</script>
