@extends('layout.default')
@section('title', $key)
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600">
    @livewire('search', [
      'posts'=>$posts,
      'users'=>$users,
      'key'=>$key,
    ])
  </main>
@endsection
