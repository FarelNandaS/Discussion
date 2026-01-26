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
              @if (auth()->user()->hasVerifiedEmail())
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

                <div class="alert alert-error shadow-sm mb-4 max-w-150">
                  <x-phosphor-warning-circle style="width: 24px; height: 24px;" />
                  <div class="flex flex-col">
                    <span class="font-bold">Security Action Required</span>
                    <span class="text-sm">
                      Please verify your email address. Without a verified email, you <strong>will not be able to recover
                        your account</strong> or reset your password if you lose access.
                    </span>
                  </div>
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
                    <span class="join-item hidden bg-error flex items-center justify-center p-1 rounded tooltip w-10"
                      data-tip="" id="feedback" title="">⏳</span>
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
            @elseif (!empty(auth()->user()->google_id))
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
          <div class="tab-content rounded-none border-t-gray-500 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

              <div class="lg:col-span-5 flex flex-col gap-6"> 
                <div class="bg-base-200/50 rounded-xl p-4 border border-gray-500 shadow-lg">
                  <div id="trust_score_chart" data-score="{{ auth()->user()->detail->trust_score }}"
                    class="w-full min-h-[250px]">
                  </div>
                </div>
              </div>

              <div class="lg:col-span-7">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                  <x-phosphor-clock-counter-clockwise class="w-5 h-5" />
                  Trust Score History
                </h3>

                <div class="bg-base-100 border border-gray-500 rounded-xl shadow-lg overflow-hidden">
                  <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                      <thead class="bg-base-200">
                        <tr>
                          <th>Date</th>
                          <th>Reason</th>
                          <th class="text-center">Adjustment</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if ($logs && $logs->count())
                          @foreach ($logs as $log)
                            <tr class="hover">
                              <td class="text-sm opacity-70">
                                {{ $log->created_at->format('d M Y, H:i') }}
                              </td>
                              <td class="font-medium italic">
                                {{ $log->reason }}
                              </td>
                              <td class="text-center">
                                @if ($log->change > 0)
                                  <div class="badge badge-success gap-1 font-bold">
                                    +{{ $log->change }}
                                  </div>
                                @else
                                  <div class="badge badge-error gap-1 font-bold text-white">
                                    {{ $log->change }}
                                  </div>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr>
                            <td colspan="3" class="text-center py-10">
                              <div class="flex flex-col items-center opacity-40">
                                <x-phosphor-folder-open class="w-12 h-12 mb-2" />
                                <p>No activity logs found yet.</p>
                              </div>
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="mt-4 flex justify-end">
                  {{-- $logs->links() --}}
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
