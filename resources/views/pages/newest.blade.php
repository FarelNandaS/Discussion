@extends('layout.default')
@section('title', 'Newest')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts && $posts->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4">Newest</h1>
      @include('components.post', ['posts' => $posts])
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        <img src="/Images/not-found.svg" alt="not found" width="80px">
        <h1 class="text-2xl font-bold">There are no posts with that word yet</h1>
      </div>
    @endif
  </main>
@endsection
