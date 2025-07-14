@extends('layout.default')
@section('title', $post->title)
@section('main')
  <main class=" min-h-[calc(100vh-60px)] min-w-full border-l border-gray-600 p-4">
    <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
      <div class="flex w-full justify-between items-center">
        <h1 class="text-2xl">{{ $post->title }}</h1>
        @if (auth()->id() == $post->id_user || auth()->user()?->role == 'admin')
          <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
            <button class="w-5" x-on:click="open = true">
              @include('icon.menu')
            </button>
            <div x-show="open" x-cloak x-transition
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex flex-col w-48 shadow-aroundShadow">
              <a href="/post/edit/{{ $post->id }}"
                class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 w-full hidden items-center gap-2"><img
                  src="/images/edit.svg" alt="edit" width="25">Edit</a>
              <form action="/post/delete/{{ $post->id }}?redirect=home" method="POST"
                class="flex w-full m-0" x-on:submit.prevent="$store.confirmDialog.show(() => $el.submit())">
                @csrf
                <button type="submit" class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex items-center w-full gap-2">
                  @include('icon.delete')
                    Delete
                  </button>
              </form>
            </div>
          </div>
        @endif
      </div>
      <p>{!! nl2br(e($post->post)) !!}</p>
      <p class="w-full flex justify-end items-center gap-x-4">
        <a href="/{{ $post->user->username }}"
          class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center h-7">
          @if (isset($post->user->image))
            <img class="rounded-full" src="/assets/profile/{{ $post->user->image }}" alt="Profile picture" width="30">
          @else
            @include('icon.user')
          @endif
          {{ $post->user->username }}
        </a>
        <span>|</span>
        <button x-data="{
          isSaved: {{ $post->isSavedByUser() ? 'true' : 'false' }},
          isLoading: false,
          async toggleSave() {
            if (this.isLoading) return;
            this.isLoading = true;
            const response = await fetch('{{url('/post/'.$post->id.'/save')}}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}',
              }
            });

            if (!response.ok) return alert('Gagal menyimpan save');

            const data = await response.json();
            this.isSaved = data.saved;
            this.isLoading = false;
          }
        }" x-on:click="toggleSave">
          <template x-if="isSaved">
            <img src="/images/saved.svg" alt="saved" width="30">
          </template>
          <template x-if="!isSaved">
            <img src="/images/save.svg" alt="save" width="30">
          </template>
        </button>
        <span>|</span>
        <button x-data="{
          isLiked: {{ $post->isLikedByUser() ? 'true' : 'false' }},
          likeCount: {{$post->likes->count() }},
          isLoading: false,
          async toggleLike() {
            if (this.isLoading) return;
            this.isLoading = true;
            const response = await fetch('{{url('/post/'.$post->id.'/like')}}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{csrf_token()}}',
              }
            });

            if (!response.ok) return alert('Gagal menyimpan like');

            const data = await response.json();
            this.isLiked = data.liked;
            this.likeCount = data.likeCount;
            this.isLoading = false;
          }
        }" x-on:click="toggleLike" class="flex items-center gap-2">
          <template x-if="isLiked">
            <img src="/images/liked.svg" alt="like" width="30">
          </template>
          <template x-if="!isLiked">
            <img src="/images/like.svg" alt="like" width="30">
          </template>
        </button>
        <span>|</span>
        <span>{{ $post->created_at->diffForHumans() }}</span>
      </p>
    </div>
    <div class="w-full relative py-4 border-b border-gray-500">
      <form action="/comment/add/{{ $post->id }}" method="POST"
        class="w-full flex justify-center items-center gap-4">
        @csrf
        <textarea 
          type="text" 
          placeholder="add comments..."
          class="rounded bg-ccblack w-full overflow-hidden resize-none p-2 border border-gray-500 autoWrap" 
          name="comment"
          rows="1" 
          x-data 
          x-init="$el.style.height = $el.scrollHeight + 'px'"
          x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' "
          x-on:keydown.enter="if (!$event.shiftKey) {
            $event.preventDefault(); 
            $el.closest('form').submit()
          }"></textarea>
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
@endsection
