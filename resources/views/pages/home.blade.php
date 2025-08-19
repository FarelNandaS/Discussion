@extends('layout.default')
@section('title', 'Home')

@section('main')
<<<<<<< HEAD
  <main class="w-full min-h-[calc(100vh-60px)] p-6">
    @if ($posts['recommendation'] && $posts['recommendation']->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4 font-bold">Recommendation Posts</h1>
      @include('components.post', ['posts' => $posts['recommendation']])
    @else
      <div class="flex flex-col items-center justify-center gap-2 p-6 min-h-[calc(100vh-60px)] text-center">
        <img src="/Images/not-found.svg" alt="not found" width="80">
=======
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600 p-4">
    @if ($posts['recommendation'] && $posts['recommendation']->count())
      <h1 class="text-2xl mb-4 border-b border-gray-500 pb-4">Recommendation Posts</h1>
      @include('components.post', ['posts' => $posts['recommendation']])
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        @include('icon.not-found')
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
        <h1 class="text-2xl font-bold">There is no post yet</h1>
      </div>
    @endif
  </main>
@endsection