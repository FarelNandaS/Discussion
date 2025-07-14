@foreach ($comments as $comment)
  <div class="flex flex-col border-b border-gray-500 py-4 gap-2">
    <div class="flex justify-between items-center">
      <a href="/{{ $comment->user->username }}"
        class="flex items-center gap-2 hover:text-primary hover:transition-all hover:duration-150 h-7">
        @if (isset($comment->user->image))
          <img src="/assets/profile/{{ $comment->user->image }}" alt="Profile picture" width="50" class="rounded-full">
        @else
          @include('icon.user')
        @endif
        {{ $comment->user->username }}
      </a>
      @if (auth()->check())
        @if (auth()->id() == $comment->id_user || auth()->user()->role == 'admin')
          <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
            <button class="w-5" x-on:click="open = true">
              @include('icon.menu')
            </button>
            <div x-show="open" x-cloak x-transition
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex flex-col w-48 shadow-aroundShadow">
              <form id="delete-comment-form-{{ $comment->id }}" action="/comment/delete/{{ $comment->id }}"
                method="POST" class="flex w-full m-0" x-on:submit.prevent="$store.confirmDialog.show(() => $el.submit())">
                @csrf
                <button type="submit" class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex items-center w-full gap-2">
                    @include('icon.delete')
                    Delete
                  </button>
              </form>
            </div>
          </div>
        @endif
      @endif
    </div>
    <p>{!! nl2br(e($comment->comment)) !!}</p>
    <div class="flex w-full justify-end">
      <p>{{ $comment->created_at->diffForHumans() }}</p>
    </div>
  </div>
@endforeach
