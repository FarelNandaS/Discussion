@extends('layout.default')
@section('title', 'Saved')
@section('main')
<<<<<<< HEAD
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
=======
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600 p-4">
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
    @if ($posts->count())
      <h1 class="text-2xl border-b border-gray-500 py-4">saved</h1>
      @include('components.post')
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        <img src="/Images/not-found.svg" alt="not found" width="80px">
        <h1 class="text-2xl font-bold">No posts saved yet</h1>
      </div>
    @endif
  </main>
@endsection
