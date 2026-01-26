@extends('layout.auth')
@section('title', 'Reset Password')
@section('main')

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md min-w-[320px] md:min-w-100 bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-base-content">New Password</h1>
                <p class="text-sm text-base-content/70 mt-2">Silakan buat password baru yang kuat untuk mengamankan akun Anda.</p>
            </div>

            <form action="{{ route('password.update') }}" method="post" class="space-y-4">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-semibold">Email Address</span>
                    </label>
                    <input type="email" name="email" value="{{ request()->email }}" 
                        class="input input-bordered bg-base-300 cursor-not-allowed w-full opacity-70" readonly>
                    @error('email')
                        <label class="label">
                            <span class="label-text-alt text-error font-medium">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control w-full">
                    <label class="label" for="password">
                        <span class="label-text font-semibold">New Password</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" 
                            placeholder="••••••••" 
                            class="input input-bordered focus:input-primary w-full pr-12 @error('password') input-error @enderror" 
                            required autofocus>
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

                <div class="form-control w-full">
                    <label class="label" for="password_confirmation">
                        <span class="label-text font-semibold">Confirm New Password</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                        placeholder="••••••••" 
                        class="input input-bordered focus:input-primary w-full" 
                        required>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary w-full shadow-md">
                        Reset Password
                    </button>
                </div>
            </form>
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