@extends('layout.default')
@section('title', 'Settings')
@section('script')
  @vite(['resources/js/setting.js'])
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]  p-4">
    <h1 class="text-2xl pb-4 font-bold">Settings</h1>
    <div class="card bg-base-100 border border-gray-500">
      <div class="card-body">
        <div class="tabs">
          <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
            aria-label="Account" checked>
          <div class="tab-content rounded-none border-t-gray-500 py-2">
            <div class="mb-4">
              <h2 class="text-lg font-medium mt-4 mb-2">Email</h2>
              @if (isset(auth()->user()->google_id))
                <div class="join mb-4 w-[320px]">
                  <input type="email" class="input join-item validator" placeholder="Enter Email Here"
                    value="{{ auth()->user()->email }}" readonly>
                  <span class="badge badge-success join-item h-10">Verified</span>
                </div>
              @else
                <div class="join mb-4 w-[320px]">
                  <input type="email" class="input join-item validator" placeholder="Enter Email Here"
                    value="{{ auth()->user()->email }}">
                  <button class="btn btn-primary join-item">Save</button>
                </div>
                <div class="mb-8">
                  <button class="btn btn-primary">Verification Email</button>
                </div>
              @endif
            </div>

            @if (empty(auth()->user()->google_id))
              <form class="mb-4" action="{{ route('settings-change-password') }}" method="POST"
                id="changePasswordForm">
                @csrf
                <h2 class="text-lg font-medium mb-4">Change Password</h2>
                <div class="flex flex-col gap-2 mb-4">
                  <label for="label">
                    <span class="label-text">Current Password</span>
                  </label>
                  <div class="join">
                    <input type="text" class="input input-sm join-item" placeholder="Your Current Password"
                      id="currentPassword" data-csrf="{{ csrf_token() }}">
                    <span class="join-item hidden bg-error items-center justify-center p-1 rounded tooltip" data-tip=""
                      id="feedback" title=""></span>
                    {{-- <p class="text-sm mt-1 hidden join-item" id="feedback"></p> --}}
                  </div>
                </div>
                <div class="flex flex-col gap-2 mb-4">
                  <label for="label">
                    <span class="label-text">New Password</span>
                  </label>
                  <input type="text" name="password" class="input input-sm" placeholder="Input New Password"
                    id="newPassword">
                </div>
                <div class="flex flex-col gap-2 mb-4">
                  <label for="label">
                    <span class="label-text">Confirm Password</span>
                  </label>
                  <input type="text" class="input input-sm" placeholder="Confirm Password" id="confirmPassword">
                </div>
                <div class="flex">
                  <button class="btn btn-primary" type="button" onclick="changePassword()">Change Password</button>
                </div>
              </form>
            @else
              <div class="mb-4">
                <h2 class="text-lg font-medium mb-4">Account Connection</h2>
                <span class="btn bg-white text-black border-[#e5e5e5] cursor-default pointer-events-none">
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
                  Connected with Google
                </span>
              </div>
            @endif
          </div>

          <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
            aria-label="Preference">
          <div class="tab-content rounded-none border-t-gray-500 py-2">
            <div class="mb-4">
              <h2 class="text-lg font-medium mt-4">Theme</h2>
              <fieldset class="fieldset">
                <label class="flex gap-2 cursor-pointer items-center">
                  <input type="radio" name="theme-radios" class="radio radio-sm" value="system" />
                  Default System
                </label>
                <label class="flex gap-2 cursor-pointer items-center">
                  <input type="radio" name="theme-radios" class="radio radio-sm" value="light" />
                  Light
                </label>
                <label class="flex gap-2 cursor-pointer items-center">
                  <input type="radio" name="theme-radios" class="radio radio-sm" value="dark" />
                  Dark
                </label>
              </fieldset>
            </div>
          </div>

          <input type="radio" class="tab text-lg checked:bg-neutral checked:text-neutral-content" name="tab-setting"
            aria-label="Trust Score">
          <div class="tab-content rounded-none border-t-gray-500 py-2">
            <div class="w-full grid grid-cols-12">
              <div class="col-span-6">
                <div class="w-full grid grid-cols-1">
                  <div class="bg-primary text-white text-center p-2">
                    <h3 class="text-xl font-semibold">Trust score logs</h3>
                  </div>
                  @if ($logs && $logs->count())
                    @foreach ($logs as $log)
                      <div class="border-y border-gray-500 p-2 flex">
                        <p>{{ ($log->change > 0 ? '+' : '') . $log->change }}</p>
                        <p>{{ $log->reason }}</p>
                      </div>
                    @endforeach
                  @else
                    <div class="border-y border-gray-500 text-center p-2">
                      <p class="text-muted italic">There is no logs yet</p>
                    </div>
                  @endif
                </div>
              </div>
              <div class="col-span-6 flex justify-center">
                <div class="mt-4 radial-progress text-center text-lg font-bold border-primary border-4"
                  style="--value: {{ auth()->user()->detail->trust_score }}; --size: 200px; --thickness: 15px;"
                  aria-valuenow="70" role="progressbar">
                  Your Trust Score <br> {{ auth()->user()->detail->trust_score }}/100
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    function changePassword() {
      const form = $('#changePasswordForm');
      const password = $('input[name="password"]').val();
      const ConfirmPassword = $('#confirmPassword').val();

      if (!$('#feedback').hasClass('bg-success')) {
        showAlert('error', 'please input your current password correctly');
        return;
      }

      if (password == '') {
        showAlert('error', 'The new password is required');
      } else if (ConfirmPassword == '') {
        showAlert('error', 'The confirm password is required');
      } else {
        showConfirm(function() {
          form.submit();
        }, 'Are you sure want to change password', "yes, i'm sure");
      }
    }
  </script>
@endsection
