@extends('layout.default')
@section('title', 'Newest')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts && $posts->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4 font-bold">Newest</h1>
      @include('components.post', ['posts' => $posts])
    @else
      <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
        <div class="opacity-40">
          {!! file_get_contents(public_path('images/not-found.svg')) !!}
        </div>
        <div class="text-center">
          <h1 class="text-2xl font-bold opacity-80">There are no new posts yet.</h1>
          <p class="text-gray-500">Be the first to share your story or thoughts today!</p>
        </div>
      </div>
    @endif
  </main>
@endsection
