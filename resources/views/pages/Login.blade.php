@extends('layout.auth')
@section('title', 'Login')
@section('main')
  <form action="" class="flex justify-center flex-col">
    <div class="flex flex-col min-w-full">
      <label for="username">Username</label>
      <input type="text" name="username">
    </div>
    <div class="flex flex-col min-w-full">
      <label for="password">Password</label>
      <input type="text" name="password">
    </div>
  </form>
@endsection
