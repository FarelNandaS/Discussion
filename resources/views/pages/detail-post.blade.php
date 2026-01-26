@extends('layout.default')
@section('title', 'Post - ' . $post->title)
@section('script')
  @vite(['resources/js/detailPost.js'])
@endsection
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="card bg-base-100 border border-gray-500 shadow-lg">
      <div class="card-body p-6">

        <div class="flex justify-between items-start gap-4 mb-6">
          <div class="">
            <h1 class="text-3xl font-black tracking-tight leading-tight">{{ $post->title }}</h1>

            <div class="flex flex-wrap gap-2 my-3">
            @foreach ($post->tags as $tag)
              <a href="/tags/{{ $tag->slug }}"
                class="badge badge-primary badge-md py-3 px-4 hover:scale-105 transition-all">
                {{ $tag->name }}
              </a>
            @endforeach
          </div>
          </div>

          <div class="flex items-center gap-2">
            {{-- Dropdown Menu (Edit/Delete/Report) --}}
            @if (auth()->check())
              <div class="dropdown dropdown-end">
                <button tabindex="0" class="btn btn-ghost btn-circle btn-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                  </svg>
                </button>
                <ul tabindex="0"
                  class="dropdown-content menu p-2 shadow-xl bg-base-200 rounded-box w-52 border border-gray-500 z-[1]">
                  @if (auth()->id() == $post->id_user || auth()->user()->hasRole('Admin'))
                    <li>
                      <a href="{{ route('post-edit', ['id' => $post->id]) }}" class="">
                        <x-tabler-edit class="w-5 h-5" /> Edit Post
                      </a>
                    </li>
                    <li>
                      <form id="delete-post-form-{{ $post->id }}" action="{{ route('post-delete') }}" method="POST"
                        onsubmit="return confirmPost({{ $post->id }})" class="flex">
                        @csrf
                        <input type="hidden" value="{{ $post->id }}" name="id">
                        <button type="submit" class="w-full flex items-center text-error">
                          <x-tabler-trash class="w-5 h-5 mr-2" /> Delete Post
                        </button>
                      </form>
                    </li>
                  @else
                    <li>
                      <button onclick="showReport('post', {{ $post->id }})" class="">
                        <x-tabler-flag class="w-5 h-5" /> Report
                      </button>
                    </li>
                  @endif
                </ul>
              </div>
            @endif
          </div>
        </div>

        @if ($post->image)
          {{-- Asumsi ada kolom image di tabel post --}}
          <div
            class="mb-8 group md:max-w-[50%] relative overflow-hidden rounded-2xl border border-gray-500/30 bg-base-200">
            {{-- Gambar dengan efek hover zoom --}}
            <img src="{{ asset('storage/posts/' . $post->image) }}" alt="{{ $post->title }}"
              class="w-full object-contain transition-transform duration-500 cursor-zoom-in"
              onclick="image_modal.showModal()" />

            {{-- Overlay gradasi tipis agar terlihat premium --}}
            <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_40px_rgba(0,0,0,0.1)]"></div>
          </div>

          {{-- Modal Pop-up untuk Full Image (DaisyUI Modal) --}}
          <dialog id="image_modal" class="modal modal-middle bg-black/80 backdrop-blur-sm">
            <div class="modal-box p-0 bg-transparent shadow-none max-w-5xl">
              <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 text-white bg-black/20">✕</button>
              </form>
              <img src="{{ asset('storage/posts/' . $post->image) }}" class="w-full h-auto" />
            </div>
            <form method="dialog" class="modal-backdrop">
              <button>close</button>
            </form>
          </dialog>
        @endif

        <article class="prose prose-md max-w-none text-base-content/90 leading-relaxed mb-8">
          {!! nl2br(e($post->content)) !!}
        </article>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-base-200">

          <div class="flex items-center gap-3">
            <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="avatar">
              <div
                class="w-10 h-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2 flex justify-center items-center">
                @if (isset($post->user->detail->image))
                  <img src="{{ asset('storage/profile/' . $post->user->detail->image) }}" class="w-full h-full" />
                @else
                  <x-tabler-user-circle class="text-gray-400 w-full h-full" />
                @endif
              </div>
            </a>
            <div>
              <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="font-bold hover:link">
                {{ $post->user->username }}
              </a>
              <p class="text-[10px] uppercase tracking-widest opacity-50">{{ $post->created_at->format('d M Y') }} •
                {{ $post->created_at->diffForHumans() }}</p>
            </div>
          </div>

          <div class="flex items-center bg-base-200 rounded-full px-4 py-1 gap-2">
            {{-- Save Button --}}
            <button id="btnSave" onclick="save({{ $post->id }})" class="btn btn-ghost btn-sm btn-circle tooltip"
              data-tip="Save Post">
              @if (auth()->user()?->hasSaved($post->id))
                <x-tabler-bookmark-filled class="w-6 h-6 text-primary" />
              @else
                <x-tabler-bookmark class="w-6 h-6" />
              @endif
            </button>

            <div class="divider divider-horizontal mx-0"></div>

            {{-- Vote Section --}}
            @php $react = auth()->user()?->reactPost($post->id); @endphp
            <div class="flex items-center gap-1">
              <button id="btnUpVote" onclick="reaction({{ $post->id }}, 'up')"
                class="btn btn-ghost btn-sm gap-2 {{ $react && $react->type == 'up' ? 'text-primary bg-primary/10' : '' }}"
                data-status="{{ $react && $react->type == 'up' ? 'active' : 'idle' }}">
                <span class="svg">
                  @if ($react && $react->type == 'up')
                    <x-phosphor-arrow-fat-up-fill class="w-6 h-6" />
                  @else
                    <x-phosphor-arrow-fat-up class="w-6 h-6" />
                  @endif
                </span>
                <span class="count font-bold">{{ $post->upVotes->count() }}</span>
              </button>

              <button id="btnDownVote" onclick="reaction({{ $post->id }}, 'down')"
                class="btn btn-ghost btn-sm gap-2 {{ $react && $react->type == 'down' ? 'text-error bg-error/10' : '' }}"
                data-status="{{ $react && $react->type == 'down' ? 'active' : 'idle' }}">
                <span class="svg">
                  @if ($react && $react->type == 'down')
                    <x-phosphor-arrow-fat-down-fill class="w-6 h-6" />
                  @else
                    <x-phosphor-arrow-fat-down class="w-6 h-6" />
                  @endif
                </span>
                <span class="count font-bold">{{ $post->downVotes->count() }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-10 mb-4 flex items-center justify-between">
      <h3 class="text-xl font-bold flex items-center gap-2">
        Comments <span class="badge badge-neutral">{{ $post->comments->count() }}</span>
      </h3>
    </div>

    <div class="card bg-base-100 border border-gray-500 shadow-lg mb-8">
      <div class="card-body p-4">
        @if (auth()->check() && auth()->user()->detail->suspend_until > now())
          <div class="bg-error/10 p-6 flex flex-col items-center text-center gap-3">
            <div class="bg-error text-white p-3 rounded-full">
              <x-phosphor-chat-centered-dots-bold class="w-8 h-8" />
            </div>
            <div>
              <h4 class="font-bold text-lg text-error">Commenting Ability Disabled</h4>
              <p class="text-sm opacity-80 max-w-md mx-auto">
                Your account is currently suspended until
                <strong>{{ auth()->user()->detail->suspend_until->format('d M Y') }}</strong>.
                You can still read discussions, but you won't be able to post new comments.
              </p>
            </div>
          </div>
        @else
          <form action="{{ route('comment-save') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <input type="hidden" value="{{ $post->id }}" name="id">
            <textarea id="addComment" name="comment" placeholder="Write a respectful comment..."
              class="textarea textarea-bordered focus:textarea-primary w-full min-h-[100px] bg-base-200/30 resize-none"></textarea>
            <div class="flex justify-end">
              <button class="btn btn-primary px-8 rounded-full">
                Post Comment
              </button>
            </div>
          </form>
        @endif
      </div>
    </div>

    <div class="space-y-4">
      @if (isset($comments) && $comments->count() > 0)
        <div id="comment_container" class="space-y-4">
          @include('components.comment')
        </div>

        <div id="load_more_status" class="flex justify-center py-4">
          <div id="loading_spinner" class="loading loading-dots loading-md hidden"></div>
        </div>
      @else
        <div class="text-center py-10 opacity-40 italic">
          No comments yet. Be the first to start the conversation!
        </div>
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
          svgEl.html(`<x-phosphor-arrow-fat-up-fill style="width: 30px; height: 30px;" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-phosphor-arrow-fat-down-fill style="width: 30px; height: 30px;" />`)
        }
      } else if (newStatus == 'idle') {
        if (type == 'up') {
          svgEl.html(`<x-phosphor-arrow-fat-up style="width: 30px; height: 30px;" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-phosphor-arrow-fat-down style="width: 30px; height: 30px;" />`)
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

    function confirmComment(id) {
      event.preventDefault();
      return showConfirm(function() {
        $('#delete-comment-form-' + id).submit();
      }, "You won't be able to revert this!", "yes, Delete it!")
    }
  </script>


@endsection
