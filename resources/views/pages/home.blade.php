@extends('layout.default')
@section('title', "Let's Disscus")

@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts['recommendation'] && $posts['recommendation']->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4 font-bold">Recommendation Posts</h1>
      @include('components.post', ['posts' => $posts['recommendation']])
    @else
      <div class="flex flex-col items-center justify-center gap-2 p-6 min-h-[calc(100vh-60px)] text-center">
        {!! file_get_contents(public_path('images/not-found.svg')) !!}
        <h1 class="text-2xl font-bold">There is no post yet</h1>
      </div>
    @endif
  </main>
@endsection
