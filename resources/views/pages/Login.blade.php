@extends('layout.auth')
@section('title', 'Login')
@section('main')
  <form action="/login/form" method="post"
    class="flex justify-center items-center flex-col bg-primary text-ccwhite p-4 gap-4 rounded w-[25%] relative">
    @csrf
    <a href="/" class="flex p-2 absolute top-0 left-0">
      <img src="/images/back.svg" alt="back" width="30">
    </a>
    <h1 class="text-2xl">Login</h1>
    <div class="flex flex-col min-w-full gap-2">
      <label for="email" class="text-l">Email</label>
      <input type="text" name="email" id="email" class="rounded text-black p-1">
    </div>

    <div class="flex flex-col min-w-full gap-2">
      <label for="password" class="text-l">Password</label>
      <div class="relative w-full">
        <input type="password" name="password" id="password" class="rounded text-black p-1 w-full">
        <button type="button" class="absolute right-0 top-1/2 transform -translate-y-1/2 mr-2"
          onclick="TogleSeePassword()"><img id="eye-icon" src="/images/eye.svg" alt="" width="25"></button>
      </div>
    </div>

    @if (!empty(session('error')))
      @include('components.error-massage', ['error' => session('error')])
    @endif

    <button type="submit"
      class="bg-light text-black rounded text-l w-full h-8 transition-all duration-150 hover:bg-darker hover:text-ccwhite hover:transition-all hover:duration-150">Login</button>

    <div class="flex justify-start items-center gap-2 min-w-full h-4">
      <input type="checkbox" name="remember">
      <label for="remember">Remember me</label>
    </div>

    <p>
      don't have an account yet? <a href="/register" class="underline">Register</a>
    </p>
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
