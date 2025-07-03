<div class=" flex flex-col w-full h-full">
  <div class="border-b border-gray-500">
    <button wire:click='changeSearch("post")' class="py-2 px-4 {{ $type == 'post' ? 'bg-gray-500' : '' }}"
      id="btnPosts">Post</button>
    <button wire:click='changeSearch("user")' class="py-2 px-4 {{ $type == 'user' ? 'bg-gray-500' : '' }}"
      id="btnPosts">User</button>
  </div>
  <div class="p-4">
    @if ($type == 'post')
      @if ($posts && $posts->count())
        <h1 class="text-xl mb-4 border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
        @include('components.post', ['posts' => $posts])
      @else
        <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
          <img src="/Images/not-found.svg" alt="not found" width="80px">
          <h1 class="text-2xl font-bold">There are no posts with that word yet</h1>
        </div>
      @endif
    @elseif($type == 'user')
      @if ($users && $users->count())
        <h1 class="text-xl border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
        @foreach ($users as $user)
          <div class="py-4 border-b border-gray-500">
            <a class="flex gap-2 items-center hover:text-primary hover:transition-all hover:duration-150"
              href="/{{ $user->username }}">
              @if ($user->image)
                <img src="/assets/profile/{{ $user->image }}" alt="profile picture" width="30" class="rounded-full">
              @else
                <img src="/assets/profile/default.svg" alt="profile picture" width="30" class="rounded-full">
              @endif
              {{ $user->username }}
            </a>
          </div>
        @endforeach
      @else
        <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
          <img src="/Images/not-found.svg" alt="not found" width="80px">
          <h1 class="text-2xl font-bold">There are no user with that word yet</h1>
        </div>
      @endif
    @endif
  </div>
</div>
