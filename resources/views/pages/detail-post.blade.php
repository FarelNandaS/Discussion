@extends('layout.default')
@section('title', 'Post - ' . $post->title)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
      <div class="flex w-full justify-between items-center">
        <h1 class="text-2xl">{{ $post->title }}</h1>
        @if (auth()->id() == $post->id_user || auth()->user()?->hasRole('Admin'))
          <div class="dropdown dropdown-end">
            <button tabindex="0"
              class="rounded-full h-9 w-9 flex items-center justify-center hover:bg-gray-500 hover:transition-all hover:duration-150">
              {!! file_get_contents(public_path('images/menu.svg')) !!}
            </button>
            <ul class="dropdown-content menu border border-gray-500 w-48 rounded p-0 bg-base-200">
              <li>
                <a href="/post/edit/{{ $post->id }}"
                  class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 w-full items-center gap-2">
                  {!! file_get_contents(public_path('images/edit.svg')) !!}Edit</a>
              </li>
              <li>
                <form id="delete-post-form-{{ $post->id }}" action="{{ route('post-delete') }}" method="POST"
                  class="flex w-full m-0 p-0" onsubmit="return confirmPost({{ $post->id }})">
                  @csrf
                  <input type="text" class="hidden" value="{{ $post->id }}" name="id">
                  <button type="submit"
                    class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex w-full gap-2">
                    {!! file_get_contents(public_path('images/delete.svg')) !!}Delete</button>
                </form>
              </li>
            </ul>
          </div>
        @endif
      </div>
      <p>{!! nl2br(e($post->post)) !!}</p>
      <p class="w-full flex justify-end items-center gap-x-4">
        <a href="{{route('profile', ['username'=>$post->user->username])}}"
          class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center">
          @if (isset($post->user->detail->image))
          <span class="w-[30px] h-[30px] overflow-hidden rounded-full">
            <img class="rounded-full object-cover w-full h-full" src="{{ asset('storage/profile/' . $post->user->detail->image ) }}" alt="Profile picture" width="30">
          </span>
          @else
            {!! file_get_contents(public_path('assets/profile/default.svg')) !!}
          @endif
          {{ $post->user->username }}
        </a>
        <span>|</span>
        {{-- @livewire('post-save', ['post' => $post], key($post->id)) --}}
        <button id="btnSave" onclick="save({{ $post->id }})">
          @if (auth()->user()?->hasSaved($post->id))
            {!! file_get_contents(public_path('images/saved.svg')) !!}
          @else
            {!! file_get_contents(public_path('images/save.svg')) !!}
          @endif
        </button>
        <span>|</span>
        <button id="btnLike" onclick="like({{ $post->id }})" class="flex items-center gap-2">
          @if (auth()->user()?->hasLiked($post->id))
            {!! file_get_contents(public_path('images/liked.svg')) !!}
          @else
            {!! file_get_contents(public_path('images/like.svg')) !!}
          @endif {{ $post->likes->count() }}
        </button>
        <span>|</span>
        <span>{{ $post->created_at->diffForHumans() }}</span>
      </p>
    </div>
    <div class="w-full relative py-4 border-b border-gray-500">
      <form action="{{ route('comment-save') }}" method="POST" class="w-full flex justify-center items-center gap-4">
        @csrf
        <input type="text" class="hidden" value="{{ $post->id }}" name="id">
        <textarea type="text" placeholder="add comments..."
          class="rounded bg-base-100 w-full overflow-hidden resize-none p-2 border border-gray-500 autoWrap" name="comment"
          rows="1" id="addComment"></textarea>
        <button class="btn btn-primary p-0">{!! file_get_contents(public_path('images/sent.svg')) !!}</button>
      </form>
    </div>
    <div class="w-full flex items-center border-b border-gray-500 py-4">
      <h1 class="text-xl">Comment</h1>
    </div>
    <div>
      @if (isset($comments))
        @include('components.comment')
      @endif
    </div>
  </main>

  <script>
    const textarea = document.getElementById('addComment');
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });

    function confirmPost(id) {
      event.preventDefault();
      return showConfirm(function() {
        $("#delete-post-form-" + id).submit();
      }, "You won't be able to revert this!", "yes, Delete it!")
    };

    let loadingSave = false;

    function save(id) {
      if ({{ auth()->check() ? 'false' : 'true' }}) {
        showAlert('warning', 'You have to log in first')
      }

      if (loadingSave) {
        return
      }

      loadingSave = true

      $('#btnSave').empty().html('<span class="loading loading-spinner loading-md"></span>');

      $.ajax({
        url: "{{ route('ajax-save-post') }}",
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
          id: id
        },
        success: function(response) {
          if (response.status == 'success') {
            if (response.saved) {
              $('#btnSave').empty().append(`{!! file_get_contents(public_path('images/saved.svg')) !!}`)
            } else {
              $('#btnSave').empty().append(`{!! file_get_contents(public_path('images/save.svg')) !!}`)
            }

            loadingSave = false;
          } else {
            console.error(response.message);
          }
        }
      })
    }

    let loadingLike = false;

    function like(id) {
      if ({{ auth()->check() ? 'false' : 'true' }}) {
        showAlert('warning', 'You have to log in first')
      }

      if (loadingSave) {
        return
      }

      loadingLike = true

      $('#btnLike').empty().html('<span class="loading loading-spinner loading-md"></span>');

      $.ajax({
        url: "{{ route('ajax-like-post') }}",
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
          id: id
        },
        success: function(response) {
          if (response.status == 'success') {
            if (response.liked) {
              $('#btnLike').empty().append(`{!! file_get_contents(public_path('images/liked.svg')) !!} ${response.count}`)
            } else {
              $('#btnLike').empty().append(`{!! file_get_contents(public_path('images/like.svg')) !!} ${response.count}`)
            }

            loadingLike = false
          } else {
            console.error(response.message);
          }
        }
      })
    }
  </script>


@endsection
