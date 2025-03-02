@extends('layout.default')
@section('title', 'Home')
@section('main')
  <main>
    <h1 class="text-2xl mb-4">Recommendation Posts</h1>
    @if (count($recommendation) > 0)
      @include('components.post', ['posts' => $recommendation])
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 ">
        <img src="/Images/not-found.svg" alt="not found" width="80px">
        <h1 class="text-2xl font-bold">There is no post yet</h1>
      </div>
    @endif
  </main>
@endsection
