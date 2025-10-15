@extends('layout.default')
@section('title', 'Profile - ' . $user->username)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="w-full flex justify-between border-b border-gray-600 py-4">
      <div class="flex flex-col gap-4">
        <div class="flex flex-col lg:flex-row gap-4">
          <div class="w-[100px] h-[100px] rounded-full overflow-hidden">
            @if (isset($user->detail->image))
              <img src="{{ asset('storage/profile/' . $user->detail->image ) }}" alt="profile image" width="100" height="100"
                class="rounded-full object-cover w-full h-full">
            @else
              {!! file_get_contents(public_path('assets/profile/detailDefault.svg')) !!}
            @endif
          </div>
          <div class="flex flex-col justify-center">
            <h1 class="text-2xl flex items-center font-bold mb-2">
              {{ $user->username }}
              @if ($user->hasRole('Admin'))
                {!! file_get_contents(public_path('images/adminBig.svg')) !!}
              @endif
            </h1>
            <div class="flex gap-4 mb-2">
              <p>{{ $user->following->count() }} Following</p>
              <p id="UserFollower">{{ $user->followers->count() }} Followers</p>
            </div>
            <p class="text-md text-gray-400 mb-2">{{ $user->detail->gender }}</p>
            <p>{{ $user->detail->bio }}</p>
          </div>
        </div>
      </div>

      @if (auth()->check())
        <div class="flex items-start justify-center h-9">
          <div class="h-full w-full flex items-center gap-2">
            @if (auth()->user()->id != $user->id)
              <div class="dropdown dropdown-end">
                <button tabindex="0" role="button"
                  class="border border-gray-500 rounded-full h-full w-9 flex items-center justify-center hover:bg-primary">
                  {!! file_get_contents(public_path('images/menu.svg')) !!}
                </button>
                <ul class="dropdown-content menu border border-gray-500 w-48 rounded p-0 bg-base-200">
                  <li><a href="" class="p-2 text-md">{!! file_get_contents(public_path('images/report.svg')) !!} Report Account</a></li>
                </ul>
              </div>
              <button
                class="border border-gray-500 rounded-full px-4 text-base h-full hover:bg-primary hover:transition-all hover:duration-150"
                id="followBtn" onclick="follow({{$user->id}})">
                @if (auth()->user()->isFollowing($user->id))
                  Unfollow
                @else
                  follow
                @endif
              </button>
            @else
              <a href="{{ route('edit-profile') }}"
                class="btn btn-ghost px-2 rounded border border-gray-500 hover:bg-primary">{!! file_get_contents(public_path('images/edit.svg')) !!}
                Edit</a>
              <form action="{{ route('logout-attempt') }}" method="POST" id="logout-attempt" class="m-0">
                @csrf
                <button type="button" onclick="confirmLogout()"
                  class="btn btn-ghost px-2 rounded border border-gray-500 hover:bg-error">
                  {!! file_get_contents(public_path('images/logout.svg')) !!}Logout
                </button>
              </form>
            @endif
          </div>
        </div>
      @endif
    </div>

    <div class="tabs">
      <input type="radio" name="tab-profile" class="tab text-lg checked:bg-primary" aria-label="Posts" checked>
      <div class="tab-content border-t-gray-500 py-2">
        @if ($posts && $posts->count() > 0)
          @include('components.post', [
              'posts' => $posts,
          ])
        @else
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            {!! file_get_contents(public_path('images/not-found.svg')) !!}
            <h1 class="text-2xl font-bold">
              No post yet
            </h1>
          </div>
        @endif
      </div>

      <input type="radio" name="tab-profile" class="tab text-lg checked:bg-primary" aria-label="Likes">
      <div class="tab-content border-t-gray-500 py-2">
        @if ($likes && $likes->count() > 0)
          @include('components.post', ['posts' => $likes])
        @else
          <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
            {!! file_get_contents(public_path('images/not-found.svg')) !!}
            <h1 class="text-2xl font-bold">
              no posts have been liked yet
            </h1>
          </div>
        @endif
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

  let loadingFollow = false;

  function follow(id) {
    if ({{ auth()->check() ? 'false' : 'true' }}) {
      showAlert('warning', 'You have to log in first')
    }

    if (loadingFollow) {
      return
    }

    loadingFollow = true
    $('#followBtn').text('Loading...');
    

    $.ajax({
      url: "{{ route('ajax-follow-user') }}",
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{csrf_token()}}'
      },
      data: {
        id: id
      },
      success: function(response) {
        if (response.status == 'success') {
          loadingFollow = false;
          if (response.isFollowing) {
            $('#followBtn').text('Unfollow');
          } else {
            $('#followBtn').text('Follow');
          }

          $('#UserFollower').text(response.followers + ' Followers');
        } else {
          showAlert('error', response.message);
          console.error(response.message);
        }
      }
    })
  }
</script>
