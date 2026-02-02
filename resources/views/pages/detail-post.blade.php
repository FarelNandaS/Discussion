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
                  @if (auth()->id() == $post->id_user || auth()->user()->hasRole('Super Admin'))
                    @if (auth()->id() == $post->id_user)
                      <li>
                        <a href="{{ route('post-edit', ['id' => $post->id]) }}" class="">
                          <x-tabler-edit class="w-5 h-5" /> Edit Post
                        </a>
                      </li>
                    @endif
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
          <div class="mb-10 group relative mr-auto w-fit max-w-full">
            {{-- Container Gambar dengan Efek Glassmorphism --}}
            <div class="relative overflow-hidden rounded-2xl border border-white/10 shadow-2xl bg-base-300">

              {{-- Overlay saat Hover --}}
              <div onclick="image_modal.showModal()"
                class="absolute inset-0 z-10 bg-black/0 group-hover:bg-black/20 transition-all duration-300 cursor-zoom-in flex items-center justify-center">
                <x-tabler-zoom-in
                  class="text-white opacity-0 group-hover:opacity-100 scale-50 group-hover:scale-100 transition-all duration-300 w-12 h-12" />
              </div>

              {{-- Gambar Utama --}}
              <div class="flex justify-center bg-base-200 rounded-2xl overflow-hidden border border-gray-500/20">
                <img src="{{ asset('storage/posts/' . $post->image) }}" class="max-h-[300px] w-auto object-contain"
                  alt="Post image">
              </div>

              {{-- Badge Metadata Gambar (Opsional) --}}
              <div class="absolute bottom-4 left-4 z-20">
                <span
                  class="badge badge-ghost bg-black/40 backdrop-blur-md text-white border-none gap-2 px-4 py-3 text-xs">
                  <x-tabler-photo class="w-4 h-4" /> Full View
                </span>
              </div>
            </div>

            {{-- Efek Bayangan Lembut di Belakang (Glow) --}}
            <div
              class="absolute -inset-1 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition duration-1000 group-hover:duration-200 -z-10">
            </div>
          </div>

          {{-- Modal Pop-up - Dibuat Lebih Bersih --}}
          <dialog id="image_modal" class="modal modal-middle backdrop-blur-md">
            <div
              class="modal-box p-0 bg-transparent shadow-none max-w-[95vw] max-h-[95vh] flex items-center justify-center">
              <form method="dialog">
                <button class="btn btn-sm btn-circle btn-primary absolute right-4 top-4 z-50 shadow-lg">✕</button>
              </form>
              <img src="{{ asset('storage/posts/' . $post->image) }}"
                class="rounded-lg max-h-[90vh] w-auto object-contain shadow-2xl border border-white/10" />
            </div>
            <form method="dialog" class="modal-backdrop bg-black/90">
              <button>close</button>
            </form>
          </dialog>
        @endif

        <article class="prose prose-md max-w-none text-base-content/90 leading-relaxed mb-8">
          {!! nl2br(e($post->content)) !!}
        </article>

        <div class="flex flex-wrap gap-2 my-3">
          @foreach ($post->tags as $tag)
            <a href="/tags/{{ $tag->slug }}"
              class="badge badge-primary badge-md py-3 px-4 hover:scale-105 transition-all">
              {{ $tag->name }}
            </a>
          @endforeach
        </div>

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
                @if ($post->user->hasRole('Admin') || $post->user->hasRole('Super Admin'))
                  <x-eos-admin style="width: 20px; height: 20px;" class="tooltip" data-tip="Admin" />
                @endif
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
              <button id="btnUpVote" onclick="reaction({{ $post->id }}, 'up')" data-tip="Upvote"
                class="btn btn-ghost btn-sm tooltip gap-2"
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

              <button id="btnDownVote" onclick="reaction({{ $post->id }}, 'down')" data-tip="Downvote"
                class="btn btn-ghost btn-sm tooltip gap-2"
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
        @if (auth()->check() && (auth()->user()->detail->suspend_until > now() || auth()->user()->detail->trust_score < 70))
          <div class="bg-error/10 p-6 flex flex-col items-center text-center gap-3">
            <div class="bg-error text-white p-3 rounded-full">
              <x-phosphor-chat-centered-dots-bold class="w-8 h-8" />
            </div>
            <div>
              <h4 class="font-bold text-lg text-error">Commenting Ability Disabled</h4>
              @if (isset(auth()->user()->detail->suspend_until))
                <p class="text-sm opacity-80 max-w-md mx-auto">
                  Your account is currently suspended until
                  <strong>{{ auth()->user()->detail->suspend_until->format('d M Y') }}</strong>.
                  You can still read discussions, but you won't be able to post new comments.
                </p>
              @else
                <p class="text-sm opacity-80 max-w-md mx-auto">
                  You cannot comment because your trust score is below 70.
                </p>
              @endif
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
              $('#btnSave').empty().append(`<x-tabler-bookmark-filled class="w-6 h-6 text-primary" />`)
            } else {
              $('#btnSave').empty().append(`<x-tabler-bookmark-filled class="w-6 h-6" />`)
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
          svgEl.html(`<x-phosphor-arrow-fat-up-fill class="w-6 h-6" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-phosphor-arrow-fat-down-fill class="w-6 h-6" />`)
        }
      } else if (newStatus == 'idle') {
        if (type == 'up') {
          svgEl.html(`<x-phosphor-arrow-fat-up class="w-6 h-6" />`)
        } else if (type == 'down') {
          svgEl.html(`<x-phosphor-arrow-fat-down class="w-6 h-6" />`)
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
