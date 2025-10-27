@extends('layout.default')
@section('title', "Search - " . $key)
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]">
    <div class=" flex flex-col w-full h-full">
      <div class="border-b border-gray-500">
        <button class="py-2 px-4 bg-gray-500" id="btnPosts" onclick="onTabPosts()">Posts</button>
        <button class="py-2 px-4" id="btnUsers" onclick="onTabUsers()">Users</button>
      </div>
      <div class="p-4" id="tabPosts">
        @if ($posts && $posts->count())
          <h1 class="text-xl mb-4 border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
          @include('components.post', ['posts' => $posts])
        @else
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            {!! file_get_contents(public_path('images/not-found.svg')) !!}
            <h1 class="text-2xl font-bold">There are no posts with that word yet</h1>
          </div>
        @endif
      </div>

      <div class="p-4 hidden" id="tabUsers">
        @if ($users && $users->count())
          <h1 class="text-xl border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
          @foreach ($users as $user)
            <div class="py-4 border-b border-gray-500">
              <a class="flex gap-2 items-center hover:text-primary hover:transition-all hover:duration-150"
                href="{{ route('profile', ['username'=>$user->username]) }}">
                <span class="w-[30px] h-[30px] rounded-full overflow-hidden">
                  @if ($user->detail->image)
                    <img src="{{ asset('storage/profile/' . $user->detail->image ) }}" alt="profile picture"
                      class="rounded-full object-cover w-full h-full">
                  @else
                    {!! file_get_contents(public_path('Images/default.svg')) !!}
                  @endif
                </span>
                {{ $user->username }}
              </a>
            </div>
          @endforeach
        @else
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            {!! file_get_contents(public_path('images/not-found.svg')) !!}
            <h1 class="text-2xl font-bold">There are no user with that word yet</h1>
          </div>
        @endif
      </div>
    </div>
  </main>

  <script>
    function onTabPosts() {
      $('#tabUsers').addClass('hidden')
      $('#tabPosts').removeClass('hidden')
      $('#btnPosts').addClass('bg-gray-500')
      $('#btnUsers').removeClass('bg-gray-500')
    }

    function onTabUsers() {
      $('#tabPosts').addClass('hidden')
      $('#tabUsers').removeClass('hidden')
      $('#btnUsers').addClass('bg-gray-500')
      $('#btnPosts').removeClass('bg-gray-500')
    }
  </script>
@endsection
