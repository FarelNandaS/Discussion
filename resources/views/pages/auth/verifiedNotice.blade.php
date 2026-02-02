@extends('layout.auth')
@section('title', 'Email Verified')
@section('main')

  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="card w-full max-w-md min-w-[320px] md:min-w-100 bg-base-100 shadow-xl border border-base-200">

      <div class="card-body text-center py-10">
        <div class="flex justify-center mb-6">
          <div class="p-4 bg-success/10 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>

        <h1 class="text-2xl font-bold text-base-content">Email Verified!</h1>
        <p class="text-sm text-base-content/70 mt-3 px-4">
          Thank you, your email has been successfully verified. You now have full access to all of our features.
        </p>

        <div class="divider my-8 uppercase text-[10px] opacity-50 tracking-widest">Finished</div>

        <a href="{{ url('/') }}" class="btn btn-primary w-full shadow-md text-white">
          Continue to Home
        </a>

        <div class="mt-6">
          <p class="text-xs text-base-content/50 italic">
            You can safely close this page.
          </p>
        </div>

      </div>
    </div>
  </div>

@endsection