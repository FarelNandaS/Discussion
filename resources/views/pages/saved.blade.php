@extends('layout.default')
@section('title', 'Saved')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts->count())
      <div class="flex justify-between border-b border-gray-500 py-4">
        <h1 class="text-2xl font-bold">saved</h1>
        <input type="date" name="sortDate" id="sortDate" class="input">
      </div>
      @include('components.post')
    @else
      <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
        <div class="opacity-40">
          {!! file_get_contents(public_path('images/not-found.svg')) !!}
        </div>
        <div class="text-center">
          <h1 class="text-2xl font-bold opacity-80">There are no saved posts yet.</h1>
          <p class="text-gray-500">Find something interesting and save it to read later!</p>
        </div>
      </div>
    @endif
  </main>
@endsection
