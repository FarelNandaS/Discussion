@extends('layout.default')
@section('title', 'Post - ' . $post->title)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="card bg-base-100 border border-gray-500">
      <div class="card-body">
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
                    <a href="{{ route('post-edit', ['id' => $post->id]) }}"
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
            @elseif (auth()->check())
              <div class="dropdown dropdown-end">
                <button tabindex="0"
                  class="rounded-full h-9 w-9 flex items-center justify-center hover:bg-gray-500 hover:transition-all hover:duration-150">
                  {!! file_get_contents(public_path('images/menu.svg')) !!}
                </button>
                <ul class="dropdown-content menu border border-gray-500 w-48 rounded p-0 bg-base-200">
                  <li>
                    <button onclick="showReport('post', {{ $post->id }})"
                      class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 w-full items-center gap-2">
                      {!! file_get_contents(public_path('Images/report.svg')) !!}
                      Report</button>
                  </li>
                </ul>
              </div>
            @endif
          </div>
          <p>{!! nl2br(e($post->content)) !!}</p>
          <p class="w-full flex justify-end items-center gap-x-4">
            <a href="{{ route('profile', ['username' => $post->user->username]) }}"
              class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center">
              @if (isset($post->user->detail->image))
                <span class="w-[30px] h-[30px] overflow-hidden rounded-full">
                  <img class="rounded-full object-cover w-full h-full"
                    src="{{ asset('storage/profile/' . $post->user->detail->image) }}" alt="Profile picture"
                    width="30">
                </span>
              @else
                {!! file_get_contents(public_path('Images/default.svg')) !!}
              @endif
              {{ $post->user->username }}
            </a>
            <span>|</span>
            {{-- @livewire('post-save', ['post' => $post], key($post->id)) --}}
            <button id="btnSave" onclick="save({{ $post->id }})" class="tooltip" data-tip="Save">
              @if (auth()->user()?->hasSaved($post->id))
                {!! file_get_contents(public_path('images/saved.svg')) !!}
              @else
                {!! file_get_contents(public_path('images/save.svg')) !!}
              @endif
            </button>
            <span>|</span>
            <?php
            $react = auth()->user()?->reactPost($post->id);
            // dd($react);
            ?>
            <button id="btnUpVote" onclick="reaction({{ $post->id }}, 'up')" class="flex items-center gap-2 tooltip"
              data-tip="upvote" data-status="{{ $react && $react->type == 'up' ? 'active' : 'idle' }}">
              @if ($react && $react->type == 'up')
                <span class="svg">
                  <x-tabler-thumb-up-filled style="width: 30px; height: 30px;" />
                </span>
                <span class="count">{{ $post->upVotes->count() }}</span>
              @else
                <span class="svg">
                  <x-tabler-thumb-up style="width: 30px; height: 30px;" />
                </span>
                <span class="count">{{ $post->upVotes->count() }}</span>
              @endif
            </button>
            <span>|</span>
            <button id="btnDownVote" onclick="reaction({{ $post->id }}, 'down')"
              class="flex items-center gap-2 tooltip" data-tip="downvote"
              data-status="{{ $react && $react->type == 'down' ? 'active' : 'idle' }}">
              @if ($react && $react->type == 'down')
                <span class="svg">
                  <x-tabler-thumb-down-filled style="width: 30px; height: 30px;" />
                </span>
                <span class="count">{{ $post->downVotes->count() }}</span>
              @else
                <span class="svg">
                  <x-tabler-thumb-down style="width: 30px; height: 30px;" />
                </span>
                <span class="count">{{ $post->downVotes->count() }}</span>
              @endif
            </button>
            <span>|</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
          </p>
        </div>

        <div class="w-full relative py-4 border-b border-gray-500">
          <form action="{{ route('comment-save') }}" method="POST"
            class="w-full flex justify-center items-center gap-4">
            @csrf
            <input type="text" class="hidden" value="{{ $post->id }}" name="id">
            <textarea type="text" placeholder="add comments..."
              class="rounded bg-base-100 w-full overflow-hidden resize-none p-2 border border-gray-500 autoWrap" name="comment"
              rows="1" id="addComment"></textarea>
            <button class="btn btn-primary p-0">{!! file_get_contents(public_path('images/sent.svg')) !!}</button>
          </form>
        </div>
        <div class="w-full flex items-center py-4">
          <h1 class="text-xl">Comment</h1>
        </div>
        <div>
          @if (isset($comments))
            @include('components.comment')
          @endif
        </div>
      </div>
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
        return
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

    let loadingReaction = false;

    function updateCount(el, change, newStatus, type) {
      const countEl = el.find('.count');
      const svgEl = el.find('.svg');
      el.data('status', newStatus);

      countEl.text(parseInt(countEl.text()) + change);
      
      if (newStatus == 'active') {
        if (type == 'up') {
          svgEl.html(`<x-tabler-thumb-up-filled style="width: 30px; height: 30px;" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-tabler-thumb-down-filled style="width: 30px; height: 30px;" />`)
        }
      } else if (newStatus == 'idle') {
        if (type == 'up') {
          svgEl.html(`<x-tabler-thumb-up style="width: 30px; height: 30px;" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-tabler-thumb-down style="width: 30px; height: 30px;" />`)
        }
      }
    }

    function rollbackReaction(upEl, downEl, oldHtmlUp, oldHtmlDown, xhr) {
      upEl.html(oldHtmlUp);
      downEl.html(oldHtmlDown);
      showAlert('error', 'Something went wrong please reload this page');
      console.error(xhr.message);
    }

    function reaction(id, type) {
      if ({{ auth()->check() ? 'false' : 'true' }}) {
        showAlert('warning', 'You have to log in first')
        return
      }

      if (loadingReaction) return;
      loadingReaction = true;

      const btnUp = $('#btnUpVote');
      const btnDown = $('#btnDownVote');
      let upCount = parseInt(btnUp.text());
      let downCount = parseInt(btnDown.text());
      const isUpActive = btnUp.data('status') == 'active';
      const isDownActive = btnDown.data('status') == 'active';

      const originalUpHtml = btnUp.html();
      const originalDownHtml = btnDown.html();

      if (type == 'up') {
        if (isUpActive) {
          updateCount(btnUp, -1, 'idle', 'up');
        } else {
          updateCount(btnUp, 1, 'active', 'up');
          if (isDownActive) updateCount(btnDown, -1, 'idle', 'down');
        }
      } else if (type == 'down') {
        if (isDownActive) {
          updateCount(btnDown, -1, 'idle', 'down');
        } else {
          updateCount(btnDown, 1, 'active', 'down');
          if (isUpActive) updateCount(btnUp, -1, 'idle', 'up');
        }
      }

      $.ajax({
        url: "{{ route('ajax-react-post') }}",
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: {
          id: id,
          type: type,
        },
        success: function(response) {
          if (response.status == 'success') {
            if (response.isChange) {
              btnUp.find('.count').text(response.countUp);
              btnDown.find('.count').text(response.countDown);
            } else {
              const target = (type == 'up') ? btnUp : btnDown;
              target.find('.count').text(response.count);
            }

            loadingReaction = false;
          } else {
            rollbackReaction(btnUp, btnDown, originalUpHtml, originalDownHtml, response);
          }
        },
        error: function(xhr) {
          rollbackReaction(btnUp, btnDown, originalUpHtml, originalDownHtml, xhr);
        }
      })
    }
  </script>


@endsection
