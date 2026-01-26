@extends('layout.auth')
@section('title', 'Verify Email')
@section('main')

  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md min-w-[320px] md:min-w-100 bg-base-100 shadow-xl border border-base-200">

      <div class="card-body text-center py-10">
        <div class="flex justify-center mb-6">
          <div class="p-4 bg-primary/10 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
        </div>

        <h1 class="text-2xl font-bold text-base-content">Verify your email</h1>
        <p class="text-sm text-base-content/70 mt-3 px-4">
          We've sent a verification link to <br>
          <span class="font-bold text-base-content">{{ auth()->user()->email }}</span>
        </p>

        @if (session('message'))
          <div class="alert alert-success mt-6 text-sm py-2">
            <span>{{ session('message') }}</span>
          </div>
        @endif

        <div class="divider my-6 uppercase text-[10px] opacity-50 tracking-widest">Action Required</div>

        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
          @csrf
          <button type="submit" class="btn btn-primary w-full shadow-md">
            Resend Verification Link
          </button>
        </form>

        <div class="collapse collapse-arrow mt-4 bg-base-200/50 rounded-xl">
          <input type="checkbox" />
          <div class="collapse-title text-sm font-medium">
            Wrong email address?
          </div>
          <div class="collapse-content">
            <p class="text-xs text-left mb-3 opacity-70">Enter your correct email below to update and resend the link.</p>

            <form method="POST" action="{{ route('verification.change') }}" class="space-y-3">
              @csrf
              <div class="form-control">
                <input type="email" name="email" placeholder="new-email@example.com"
                  class="input input-sm input-bordered focus:input-primary w-full @error('email') input-error @enderror"
                  required>
                @error('email')
                  <label class="label text-xs text-error font-medium">{{ $message }}</label>
                @enderror
              </div>
              <button type="submit" class="btn btn-ghost btn-sm w-full border-base-300">
                Update & Resend
              </button>
            </form>
          </div>
        </div>

        <div class="mt-8 pt-6 border-t border-base-200">
          <form method="POST" action="{{ route('logout-attempt') }}">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm gap-2 opacity-70 hover:opacity-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              Logout and try again
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
