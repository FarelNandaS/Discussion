@extends('layout.auth')
@section('title', 'Forgot Password')
@section('main')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md bg-base-100 shadow-xl relative">
        
        <div class="absolute top-4 left-4">
            <a href="{{ route('login') }}" class="btn btn-ghost btn-circle btn-sm">
                {!! file_get_contents(public_path('images/back.svg')) !!}
            </a>
        </div>

        <div class="card-body pt-12">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-base-content">Reset Password</h1>
                <p class="text-sm text-base-content/70 mt-2">
                    Forgot your password? Don't worry. Enter your email and we'll send you a reset link.
                </p>
            </div>

            <form action="{{ route('forgot-password-send') }}" method="post" class="space-y-4">
                @csrf

                <div class="form-control w-full">
                    <label class="label" for="email">
                        <span class="label-text font-semibold">Email Address</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                        placeholder="name@example.com" 
                        class="input input-bordered focus:input-primary w-full @error('email') input-error @enderror" 
                        required autofocus>
                    
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 mt-6">
                    <button type="submit" class="btn btn-primary w-full shadow-md">
                        Send Reset Link
                    </button>
                    
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-block text-sm opacity-70 hover:opacity-100">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection