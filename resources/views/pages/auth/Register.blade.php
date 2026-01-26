@extends('layout.auth')
@section('title', 'Register')
@section('main')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md min-w-[320px] md:min-w-100 bg-base-100 shadow-xl relative">
        
        <div class="absolute top-4 left-4">
            <a href="/login" class="btn btn-ghost btn-circle btn-sm">
                {!! file_get_contents(public_path('images/back.svg')) !!}
            </a>
        </div>

        <div class="card-body pt-12">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-base-content">Create Account</h1>
                <p class="text-sm text-base-content/70 mt-2">Register now to start using our services.</p>
            </div>

            <form action="{{ route('register-attempt') }}" method="post" class="space-y-4">
                @csrf

                <div class="form-control w-full">
                    <label class="label" for="username">
                        <span class="label-text font-semibold">Username</span>
                    </label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" 
                        placeholder="johndoe" 
                        class="input input-bordered focus:input-primary w-full @error('username') input-error @enderror" 
                        required autofocus>
                    @error('username')
                        <label class="label">
                            <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label" for="email">
                        <span class="label-text font-semibold">Email Address</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        placeholder="name@example.com" 
                        class="input input-bordered focus:input-primary w-full @error('email') input-error @enderror" 
                        required>
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label" for="password">
                        <span class="label-text font-semibold">Password</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" 
                            placeholder="••••••••" 
                            class="input input-bordered focus:input-primary w-full pr-12 @error('password') input-error @enderror" 
                            required>
                        <button type="button" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 btn btn-ghost btn-xs btn-circle text-base-content/50" 
                            id="togglePassword">
                            <span id="eyeOpen">{!! file_get_contents(public_path('Images/eye.svg')) !!}</span>
                            <span id="eyeSlash" class="hidden">{!! file_get_contents(public_path('Images/eye-slash.svg')) !!}</span>
                        </button>
                    </div>
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 mt-6">
                    <button type="submit" class="btn btn-primary w-full shadow-md">
                        Register
                    </button>

                    <div class="divider text-xs opacity-50 uppercase">Or register with</div>

                    <a href="{{ route('auth-google') }}" class="btn btn-outline btn-ghost w-full gap-3 border-base-300">
                        <svg width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                            <path fill="#FF3D00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                        </svg>
                        Google Account
                    </a>
                </div>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm">
                    Already have an account? 
                    <a href="/login" class="link link-primary font-bold">Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

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