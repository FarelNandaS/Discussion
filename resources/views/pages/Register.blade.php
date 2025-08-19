@extends('layout.auth')
@section('title', 'Register')
@section('main')
  <form action="/register/form" method="post"
    class="flex justify-center items-center flex-col bg-primary text-ccwhite p-4 gap-4 rounded w-[25%] relative">
    @csrf
    <a href="/login" class="flex p-2 absolute top-0 left-0">
      <img src="/images/back.svg" alt="back" width="30">
    </a>
    <h1 class="text-2xl">Register</h1>
    <div class="flex flex-col min-w-full">
      <label for="username" class="text-l">Username</label>
      <input type="text" name="username" id="username" class="rounded text-black p-1">
    </div>

    @if (!empty(session('error')?->first('username')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('username') }}</p>
      </div>
    @endif

    <div class="flex flex-col min-w-full">
      <label for="email" class="text-l">Email</label>
      <input type="text" name="email" id="email" class="rounded text-black p-1">
    </div>

    @if (!empty(session('error')?->first('email')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('email') }}</p>
      </div>
    @endif

    <div class="flex flex-col min-w-full">
      <label for="password" class="text-l">Password</label>
      <div class="relative w-full">
        <input type="password" name="password" id="password" class="rounded text-black p-1 w-full">
        <button type="button" class="absolute right-0 top-1/2 transform -translate-y-1/2 mr-2"
          onclick="TogleSeePassword()"><img id="eye-icon" src="/images/eye.svg" alt="" width="25"></button>
      </div>
    </div>

    @if (!empty(session('error')?->first('password')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('password') }}</p>
      </div>
    @endif

    <button type="submit"
      class="bg-light text-black rounded text-l w-full h-8 transition-all duration-150 hover:bg-darker hover:text-ccwhite hover:transition-all hover:duration-150">Register</button>
  </form>

  <script>
    function TogleSeePassword() {
      var password = document.getElementById('password');
      var icon = document.getElementById('eye-icon');

      if (password.type === "password") {
        password.type = "text";
        icon.src = "/images/eye-slash.svg"
      } else if (password.type === "text") {
        password.type = "password";
        icon.src = "/images/eye.svg";
      }
    }
  </script>
@endsection
