@extends('layout.default')
@section('title', $user?->username)
@section('main')
<<<<<<< HEAD
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="w-full flex justify-between border-b border-gray-600 py-4">
      <div class="flex flex-col gap-4">
        <div class="flex w-full justify-between">
          <h1 class="text-2xl flex items-center gap-4">
=======
  <main class=" min-h-[calc(100vh-60px)] min-w-full border-l border-gray-600 p-4">
    <div class="w-full flex justify-between border-b border-gray-600 py-4" x-data="{
        isFollow: {{ $user->isFollowedByUser() ? 'true' : 'false' }},
        countFollowers: {{ $user->followers->count() }},
        countFollowing: {{ $user->following->count() }},
        isFollowLoading: false,
    
        async toggleFollow() {
            if (this.isFollowLoading) return;
            this.isFollowLoading = true;
            const response = await fetch('{{ url('/follow/' . $user->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
    
            if (!response.ok) return console.log(response);
    
            const data = await response.json();
            this.isFollow = data.followed;
            this.countFollowers = data.countFollowers;
            this.isFollowLoading = false;
        },
    }">
      <div class="flex flex-col gap-4">
        <div class="flex w-full justify-between">
          <h1 class="text-2xl flex items-center gap-4 max-h-[100px]">
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
            @if (isset($user->image))
              <img src="/assets/profile/{{ $user->image }}" alt="profile image" width="100" height="100"
                class="rounded-full">
            @else
<<<<<<< HEAD
              <img src="/assets/profile/default.svg" alt="profile image" width="100" height="100"
                class="rounded-full">
=======
              @include('icon.user')
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
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
<<<<<<< HEAD
        @livewire('follow-count', ['user' => $user])
=======
        <div class="flex gap-4">
          <p x-text=" 'Following ' + countFollowing "></p>
          <p x-text=" 'Followers ' + countFollowers "></p>
        </div>
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
      </div>

      @if (auth()->check())
        <div class="flex gap-2 items-start justify-center h-9">
<<<<<<< HEAD
          <div class="relative h-full w-full flex items-center">
            <button id="btn-dropdown-profile"
              class="border border-gray-500 rounded-full h-full w-9 flex items-center justify-center hover:bg-gray-500 hover:transition-all hover:duration-150" onclick="return showDropdown('profile')">
              <img src="/images/menu.svg" alt="menu" width="30">
            </button>
            <div id="dropdown-menu-profile"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex-col w-48 shadow-aroundShadow hidden">
=======
          <div class="relative h-full w-full flex items-center" x-data="{ open: false }" x-on:click.away="open=false">
            <button
              class="border border-gray-500 rounded-full h-full w-9 flex items-center justify-center hover:bg-gray-500 hover:transition-all hover:duration-150"
              x-on:click="open = true">
              @include('icon.menu')
            </button>
            <div
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex-col w-48 shadow-aroundShadow"
              x-show="open" x-cloak x-transition>
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
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
<<<<<<< HEAD
            @livewire('follow-button', ['user' => $user])
=======
            <button x-on:click="toggleFollow"
              class="border border-gray-500 rounded-full px-4 text-base h-full hover:bg-gray-500 hover:transition-all hover:duration-150">
              <template x-if="isFollow">
                <span>
                  Unfollow
                </span>
              </template>
              <template x-if="!isFollow">
                <span>
                  follow
                </span>
              </template>
            </button>
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
          @endif
        </div>
      @endif

    </div>
<<<<<<< HEAD
    @livewire('profile-content', [
        'username' => $user->username,
    ])
=======
    <div x-data="{ 
      type: 'post',
      likes
    }" 
    x-init="{

    }">
      <div class="flex border-b border-gray-500">
        <button class="py-2 px-4" :class="type == 'post' ? 'bg-gray-500' : ''" x-on:click="type = 'post' ">Posts</button>
        <button class="py-2 px-4" :class="type == 'like' ? 'bg-gray-500' : ''" x-on:click="type = 'like' ">Likes</button>
      </div>
      <div id="content" class="" x-cloak x-show="type == 'post' ">
        @if ($user->posts->count() == 0)
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            @include('icon.not-found')
            <h1 class="text-2xl font-bold">
              No post yet
            </h1>
          </div>
        @else
          @include('components.post', [
              'posts' => $user->posts,
          ])
        @endif
      </div>
      <div id="content" class="" x-cloak x-show="type == 'like' ">
        @if ($user->likes->count() == 0)
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            @include('icon.not-found')
            <h1 class="text-2xl font-bold">
              no posts have been liked yet
            </h1>
          </div>
        @else
          @include('components.post', [
              'posts' => $user->likes,
          ])
        @endif
      </div>
    </div>


>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
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
