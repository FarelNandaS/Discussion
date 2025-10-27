@extends('layout.default')
@section('title', 'Saved')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts->count())
      <h1 class="text-2xl border-b border-gray-500 py-4">saved</h1>
      @include('components.post')
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        {!! file_get_contents(public_path('Images/not-found.svg')) !!}
        <h1 class="text-2xl font-bold">No posts saved yet</h1>
      </div>
    @endif
  </main>
@endsection
