@extends('layout.default')
@section('title', $post->title)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full border-l border-gray-600 p-4">
    <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
      <div class="flex w-full justify-between items-center">
        <h1 class="text-2xl">{{ $post->title }}</h1>
        @if (auth()->id() == $post->id_user || auth()->user()?->role == 'admin')
          <div class="relative">
            <button id="btn-dropdown-detail-post" class="w-5" onclick="return showDropdown('detail-post')">
              <img src="/images/menu.svg" alt="menu" width="30">
            </button>
            <div id="dropdown-menu-detail-post"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded hidden flex-col w-48 shadow-aroundShadow">
              <a href="/post/edit/{{ $post->id }}"
                class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 w-full hidden items-center gap-2"><img
                  src="/images/edit.svg" alt="edit" width="25">Edit</a>
              <form id="delete-post-form-{{ $post->id }}" action="/post/delete/{{ $post->id }}" method="POST"
                class="flex w-full m-0" onsubmit="return confirmPost({{ $post->id }})">
                @csrf
                <button type="submit"
                  class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex w-full gap-2"><img
                    src="/images/delete.svg" alt="delete" width="25">Delete</button>
              </form> 
            </div>
          </div>
        @endif
      </div>
      <p>{!! nl2br(e($post->post)) !!}</p>
      <p class="w-full flex justify-end items-center gap-x-4">
        <a href="/{{ $post->user->username }}"
          class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center">
          @if (isset($post->user->image))
            <img class="rounded-full" src="/assets/profile/{{ $post->user->image }}" alt="Profile picture" width="30">
          @else
            <img class="rounded-full" src="/assets/profile/default.svg" alt="Profile picture" width="30">
          @endif
          {{ $post->user->username }}
        </a>
        <span>|</span>
        @livewire('post-save', ['post' => $post], key($post->id))
        <span>|</span>
        @livewire('post-like', ['post' => $post], key($post->id))
        <span>|</span>
        <span>{{ $post->created_at->diffForHumans() }}</span>
      </p>
    </div>
    <div class="w-full relative py-4 border-b border-gray-500">
      <form action="/comment/add/{{ $post->id }}" method="POST"
        class="w-full flex justify-center items-center gap-4">
        @csrf
        <textarea type="text" placeholder="add comments..."
          class="rounded bg-ccblack w-full overflow-hidden resize-none p-2 border border-gray-500 autoWrap" name="comment"
          rows="1" id="addComment"></textarea>
        <button class=""><img src="/images/sent.svg" alt="Sent" width="40"
            class="bg-primary p-2 rounded"></button>
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
  </script>
@endsection

<script>
  function confirmPost(id) {
    event.preventDefault();
    return showConfirm(function() {
      document.getElementById("delete-post-form-" + id).submit();
    }, "You won't be able to revert this!", "yes, Delete it!")
  }
</script>
