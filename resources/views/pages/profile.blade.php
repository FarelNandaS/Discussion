@extends('layout.default')
@section('title', 'Profile - ' . $user->username)
@section('script')
  @vite(['resources/js/profile.js'])
@endsection
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="card bg-base-100 border border-gray-500">
      <div class="card-body gap-0">
        <div class="w-full flex justify-between py-4">
          <div class="flex flex-col gap-4">
            <div class="flex flex-col lg:flex-row gap-4">
              <div class="w-[100px] h-[100px] rounded-full overflow-hidden">
                @if (isset($user->detail->image))
                  <img src="{{ asset('storage/profile/' . $user->detail->image) }}" alt="profile image" width="100"
                    height="100" class="rounded-full object-cover w-full h-full">
                @else
                  {!! file_get_contents(public_path('Images/detailDefault.svg')) !!}
                @endif
              </div>
              <div class="flex flex-col justify-center">
                <h1 class="text-2xl flex items-center font-bold mb-2">
                  {{ $user->username }}
                  @if ($user->hasRole('Admin'))
                    <x-eos-admin style="width: 30px; height: 30px;" />
                  @endif
                </h1>
                {{-- <p> {{$user->detail->trust_score}}</p> --}}
                @if ($user->detail->gender)
                  <p class="text-md text-gray-400 mb-2">{{ $user->detail->gender }}</p>
                @endif
                @if ($user->detail->bio)
                  <p>{{ $user->detail->bio }}</p>
                @endif
              </div>
            </div>
          </div>

          @if (auth()->check())
            <div class="flex items-start justify-center h-9">
              <div class="h-full w-full flex items-center gap-2">
                @if (auth()->user()->id != $user->id)
                  {{-- <div class="dropdown dropdown-end">
                    <button tabindex="0" role="button"
                      class="border border-gray-500 rounded-full h-full w-9 flex items-center justify-center hover:bg-primary">
                      {!! file_get_contents(public_path('images/menu.svg')) !!}
                    </button>
                    <ul class="dropdown-content menu border border-gray-500 w-48 rounded p-0 bg-base-200">
                      <li><a href="" class="p-2 text-md">{!! file_get_contents(public_path('images/report.svg')) !!} Report Account</a></li>
                    </ul>
                  </div> --}}
                @else
                  @if (request()->is('admin*'))
                    <a href="{{ route('admin-edit-profile') }}"
                      class="btn btn-ghost px-2 rounded border border-gray-500 hover:bg-primary hover:text-white">{!! file_get_contents(public_path('images/edit.svg')) !!}
                      Edit</a>
                  @else
                    <a href="{{ route('edit-profile') }}"
                      class="btn btn-ghost px-2 rounded border border-gray-500 hover:bg-primary hover:text-white">{!! file_get_contents(public_path('images/edit.svg')) !!}
                      Edit</a>
                  @endif
                @endif
              </div>
            </div>
          @endif
        </div>

        {{-- <div class="w-full py-2">
          <h1 class="text-2xl font-bold">User posts:</h1>
          @if ($posts && $posts->count() > 0)
            @include('components.post', [
                'posts' => $posts,
            ])
          @else
            <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
              <div class="opacity-40">
                {!! file_get_contents(public_path('images/not-found.svg')) !!}
              </div>
              <div class="text-center">
                <h1 class="text-2xl font-bold opacity-80">There are no posts yet.</h1>
                <p class="text-gray-500">User has not created a post yet</p>
              </div>
            </div>
          @endif
        </div> --}}

        <div class="w-full mt-10">
          {{-- Judul dengan garis dekoratif --}}
          <div class="flex items-center gap-4 mb-2">
            <h2 class="text-2xl font-black tracking-tight whitespace-nowrap">User Posts</h2>
            <div class="h-[2px] w-full bg-base-200"></div>
          </div>

          @if ($posts && $posts->count() > 0)
            <div id="post_container">
              @include('components.post', ['posts' => $posts])
            </div>

            <div id="load_more_status" class="flex justify-center py-4">
              <div id="loading_spinner" class="loading loading-dots loading-md hidden"></div>
            </div>
          @else
            {{-- Empty State yang lebih menarik --}}
            <div
              class="flex justify-center items-center flex-col gap-4 py-16 w-full bg-base-200/20 rounded-3xl border-2 border-dashed border-base-300">
              <div class="bg-base-100 p-6 rounded-full shadow-inner">
                <x-tabler-article-off class="w-12 h-12 opacity-20" />
              </div>
              <div class="text-center">
                <h3 class="text-lg font-bold opacity-80">No stories yet</h3>
                <p class="text-sm text-base-content/50">This user hasn't published any posts.</p>
              </div>
            </div>
          @endif
        </div>

      </div>
    </div>
  </main>
@endsection

<script>
  function confirmLogout() {
    event.preventDefault();
    return showConfirm(function() {
      $("#logout-attempt").submit();
    }, "you can log back into this account", "Yes, logout from this account")
  }

  function confirmGiveAccess(id) {
    event.preventDefault();
    return showConfirm(function() {
      $("#give-access-form-" + id).submit();
    }, "Are you sure about giving this account admin access", "Yes, give admin access")
  }

  function confirmDeleteAccess(id) {
    event.preventDefault();
    return showConfirm(function() {
      $("#delete-access-form-" + id).submit();
    }, "You can grant access to this account again", "Yes, remove admin access")
  }

  function onTabPosts() {
    $('#tabLikes').addClass('hidden')
    $('#tabPosts').removeClass('hidden')
    $('#btnPosts').addClass('bg-gray-500')
    $('#btnLikes').removeClass('bg-gray-500')
  }

  function onTabLikes() {
    $('#tabPosts').addClass('hidden')
    $('#tabLikes').removeClass('hidden')
    $('#btnLikes').addClass('bg-gray-500')
    $('#btnPosts').removeClass('bg-gray-500')
  }
</script>
