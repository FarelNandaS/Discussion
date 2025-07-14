@extends('layout.default')
@section('title', 'Home')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600 p-4">
    @if ($posts['recommendation'] && $posts['recommendation']->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4">Recommendation Posts</h1>
      @include('components.post', ['posts' => $posts['recommendation']])
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        @include('icon.not-found')
        <h1 class="text-2xl font-bold">There is no post yet</h1>
      </div>
    @endif
  </main>
@endsection