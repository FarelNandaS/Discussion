@extends('layout.default')
@section('title', $key)
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]">
    @livewire('search', [
      'posts'=>$posts,
      'users'=>$users,
      'key'=>$key,
    ])
  </main>
@endsection
