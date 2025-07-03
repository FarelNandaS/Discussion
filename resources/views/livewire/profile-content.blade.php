<div>
  <div class="flex border-b border-gray-500">
    <button wire:click='setType("posts")' class="py-2 px-4 {{ $type == 'posts' ? 'bg-gray-500' : '' }}"
      id="btnPosts">Posts</button>
    <button wire:click='setType("likes")' class="py-2 px-4 {{ $type == 'likes' ? 'bg-gray-500' : '' }}"
      id="btnPosts">Likes</button>
  </div>
  <div id="content" class="">
    @if ($content && $content->count())
      @if ($type == 'posts')
        @include('components.post', [
            'posts' => $content,
        ])
      @elseif($type == 'likes')
        @include('components.post', [
            'posts' => $content,
        ])
      @endif
    @else
      <div class="flex justify-center items-center flex-col gap-2 p-4 w-full min-h-[calc(100vh-60px)]">
        <img src="/Images/not-found.svg" alt="not found" width="80px">
        <h1 class="text-2xl font-bold">
          @if ($type == 'posts')
            No post yet
          @elseif($type == 'likes')
            no posts have been liked yet
          @endif
        </h1>
      </div>
    @endif
  </div>
</div>
