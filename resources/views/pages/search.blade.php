@extends('layout.default')
@section('title', 'Search - ' . $key)
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]">
    <div class=" flex flex-col w-full h-full p-4">
      <div class="tabs">
        <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
          aria-label="Posts" checked>
        <div class="tab-content border-t-gray-500 p-4">
          @if ($posts && $posts->count())
            <h1 class="text-xl mb-4 pb-4">Search "{{ $key }}"</h1>
            @include('components.post', ['posts' => $posts])
          @else
            <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
              {!! file_get_contents(public_path('images/not-found.svg')) !!}
              <h1 class="text-2xl font-bold">There are no posts with that word yet</h1>
            </div>
          @endif
        </div>

        <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
          aria-label="Users">
        <div class="tab-content border-t-gray-500 p-4">
          @if ($users && $users->count())
            <h1 class="text-xl pb-4">Search "{{ $key }}"</h1>
            @foreach ($users as $user)
            <div class="card bg-base-100 border border-gray-500">
              <div class="card-body">
                <a class="flex gap-2 items-center hover:text-primary hover:transition-all hover:duration-150"
                  href="{{ route('profile', ['username' => $user->username]) }}">
                  <span class="w-[30px] h-[30px] rounded-full overflow-hidden">
                    @if ($user->detail->image)
                      <img src="{{ asset('storage/profile/' . $user->detail->image) }}" alt="profile picture"
                        class="rounded-full object-cover w-full h-full">
                    @else
                      <x-tabler-user-circle style="width: 30px; height: 30px;"/>
                    @endif
                  </span>
                  <div class="flex flex-column">
                    {{ $user->username }}
                    <div class="">{{ $user->posts->count() }}</div>
                  </div>
                </a>
              </div>
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
    </div>
  </main>
@endsection
