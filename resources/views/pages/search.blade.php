@extends('layout.default')
@section('title', 'Search for ' . $key)
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600">
    <div class="flex flex-col w-full h-full" x-data="{ type: 'post' }">
      <div class="border-b border-gray-500">
        <button class="py-2 px-4 " :class="type == 'post' ? 'bg-gray-500' : ''" x-on:click="type = 'post' ">Post</button>
        <button class="py-2 px-4 " :class="type == 'user' ? 'bg-gray-500' : ''" x-on:click="type = 'user' ">User</button>
      </div>
      <div class="p-4">
        <div x-cloak x-show="type == 'post' ">
          @if ($posts->count() != 0)
            <h1 class="text-xl mb-4 border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
            @include('components.post', ['posts' => $posts])
          @else
            <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
              @include('icon.not-found')
              <h1 class="text-2xl font-bold">There are no posts with that word yet</h1>
            </div>
          @endif
        </div>

        <div x-cloak x-show="type == 'user' ">
          @if ($users->count() != 0)
            <h1 class="text-xl border-b border-gray-500 pb-4">Search "{{ $key }}"</h1>
            @include('components.users', [
              'users' => $users,
            ])
          @else
            <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
              @include('icon.not-found')
              <h1 class="text-2xl font-bold">There are no user with that word yet </h1>
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>
@endsection
