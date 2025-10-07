@extends('layout.auth')
@section('title', 'Login')
@section('main')
  <form action="{{ route('login-attempt') }}" method="post"
    class="flex justify-center items-center flex-col bg-base-200 text-ccwhite p-4 gap-4 rounded w-[25%] relative">
    @csrf
    <a href="/" class="flex p-2 absolute top-0 left-0">
      {!! file_get_contents(public_path('images/back.svg')) !!}
    </a>
    <h1 class="text-2xl">Login</h1>
    <div class="flex flex-col min-w-full gap-2">
      <label for="email" class="text-l">Email</label>
      <input type="text" name="email" id="email" class="input" placeholder="Enter Email Here">
    </div>

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

    @if (!empty(session('error')))
      @include('components.error-massage', ['error' => session('error')])
    @endif

    <button type="submit" class="btn btn-primary w-full">Login</button>
    <a class="btn bg-white text-black border-[#e5e5e5] w-full" href="{{route('auth-google')}}">
      <svg aria-label="Google logo" width="16" height="16" xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 512 512">
        <g>
          <path d="m0 0H512V512H0" fill="#fff"></path>
          <path fill="#34a853" d="M153 292c30 82 118 95 171 60h62v48A192 192 0 0190 341"></path>
          <path fill="#4285f4" d="m386 400a140 175 0 0053-179H260v74h102q-7 37-38 57"></path>
          <path fill="#fbbc02" d="m90 341a208 200 0 010-171l63 49q-12 37 0 73"></path>
          <path fill="#ea4335" d="m153 219c22-69 116-109 179-50l55-54c-78-75-230-72-297 55"></path>
        </g>
      </svg>
      Login with Google
    </a>

    <div class="flex justify-start items-center gap-2 min-w-full h-4">
      <input type="checkbox" name="remember" class="checkbox checkbox-primary">
      <label for="remember">Remember me</label>
    </div>

    <p>
      don't have an account yet? <a href="/register" class="underline">Register</a>
    </p>
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
