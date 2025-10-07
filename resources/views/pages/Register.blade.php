@extends('layout.auth')
@section('title', 'Register')
@section('main')
  <form action="{{ route('register-attempt') }}" method="post"
    class="flex justify-center items-center flex-col bg-base-200 p-4 gap-4 rounded w-[25%] relative">
    @csrf
    <a href="/login" class="flex p-2 absolute top-0 left-0">
      {!! file_get_contents(public_path('images/back.svg')) !!}
    </a>
    <h1 class="text-2xl">Register</h1>
    <div class="flex flex-col min-w-full gap-2">
      <label for="username" class="text-l">Username</label>
      <input type="text" name="username" id="username" class="input" placeholder="Enter Username Here">
    </div>

    @if (!empty(session('error')?->first('username')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('username') }}</p>
      </div>
    @endif

    <div class="flex flex-col min-w-full gap-2">
      <label for="email" class="text-l">Email</label>
      <input type="text" name="email" id="email" class="input" placeholder="Enter Email Here">
    </div>

    @if (!empty(session('error')?->first('email')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('email') }}</p>
      </div>
    @endif

    <div class="flex flex-col min-w-full gap-2">
      <label for="password" class="text-l">Password</label>
      <div class="relative w-full">
        <input type="password" name="password" id="password" class="input" placeholder="Enter Password Here">
        <button type="button" class="absolute right-0 top-1/2 transform -translate-y-1/2 mr-2" id="togglePassword">
          {!! file_get_contents(public_path('Images/eye.svg')) !!}
          {!! file_get_contents(public_path('Images/eye-slash.svg')) !!}
        </button>
      </div>
    </div>

    @if (!empty(session('error')?->first('password')))
      <div class="flex justify-center items-center text-ccwhite bg-red-600 w-full h-8 rounded">
        <p>{{ session('error')->first('password') }}</p>
      </div>
    @endif

    <button type="submit" class="btn btn-primary w-full">Register</button>
  </form>

  <script>
    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeSlash = document.getElementById('eyeSlash');

    toggle.addEventListener('click', () => {
      const isHidden = password.type === 'password';
      password.type = isHidden ? 'text' : 'password';
      eyeOpen.classList.toggle('hidden', isHidden);
      eyeSlash.classList.toggle('hidden', !isHidden);
    });
  </script>
@endsection
