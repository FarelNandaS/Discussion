@extends('layout.default')
@section('title', 'Search - ' . $key)
@section('script')
  @vite(['resources/js/search.js'])
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]">
    <div class=" flex flex-col w-full h-full p-4">
      <div class="tabs">
        <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
          aria-label="Posts" checked>
        <div class="tab-content border-t-gray-500 p-4">
          @if ($posts && $posts->count())
            <div class="flex justify-between items-center">
              <h1 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-6">
                Post Search Results: <span class="text-primary">"{{ $key }}"</span>
              </h1>

              <input type="date" name="sortDate" id="sortDate" class="input">
            </div>

            <div class="" id="post_container" data-key="{{ $key }}">
              @include('components.post', ['posts' => $posts])
            </div>

            <div id="load_more_status" class="flex justify-center py-4">
              <div id="loading_spinner" class="loading loading-dots loading-md hidden"></div>
            </div>
          @else
            <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
              <div class="opacity-40">
                {!! file_get_contents(public_path('images/not-found.svg')) !!}
              </div>
              <div class="text-center">
                <h1 class="text-2xl font-bold opacity-80">Post Not Found</h1>
                <p class="text-gray-500">Try using other keywords to find the post you want.</p>
              </div>
            </div>
          @endif
        </div>

        <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
          aria-label="Users">
        <div class="tab-content border-t-gray-500 p-4">
          @if ($users && $users->count())
            <h1 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-6">
              User Search Results: <span class="text-primary">"{{ $key }}"</span>
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @foreach ($users as $user)
                <div
                  class="group flex items-center justify-between p-4 rounded-2xl bg-base-100 border border-gray-500 shadow-lg hover:border-primary/50 transition-all duration-200">

                  <a class="flex gap-4 items-center flex-grow"
                    href="{{ route('profile', ['username' => $user->username]) }}">
                    <div class="relative">
                      <div
                        class="w-14 h-14 rounded-full overflow-hidden border-2 border-base-200 group-hover:border-primary/30 transition-colors">
                        @if ($user->detail->image)
                          <img src="{{ asset('storage/profile/' . $user->detail->image) }}" alt="profile picture"
                            class="object-cover w-full h-full">
                        @else
                          <div class="bg-base-200 w-full h-full flex items-center justify-center text-gray-400">
                            <x-tabler-user-circle class="w-10 h-10" />
                          </div>
                        @endif
                      </div>
                    </div>

                    <div class="flex flex-col">
                      <span class="font-bold text-lg group-hover:text-primary transition-colors">
                        {{ $user->username }}
                        @if ($user->hasRole('Admin') || $user->hasRole('Super Admin'))
                          <x-eos-admin style="width: 25px; height: 25px;" class="tooltip" data-tip="Admin" />
                        @endif
                      </span>
                      <div>
                        <span class="text-sm text-gray-500 me-4">
                          {{ $user->detail->trust_score }} Trust Score
                        </span>
                        <span class="text-sm text-gray-500">
                          {{ $user->posts->count() }} {{ Str::plural('Post', $user->posts->count()) }}
                        </span>
                      </div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
              <div class="opacity-40">
                {!! file_get_contents(public_path('images/not-found.svg')) !!}
              </div>
              <div class="text-center">
                <h1 class="text-2xl font-bold opacity-80">User Not Found</h1>
                <p class="text-gray-500">Try using other keywords to search for your friends.</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>

  <script></script>
@endsection
