@foreach ($posts as $post)
  <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
    <div class="flex justify-between items-center">
      <a class="text-xl w-max hover:text-primary hover:transition-all hover:duration-150"
        href="/post/detail/{{ $post->id }}">{{ $post->title }}</a>
      @if (auth()->check() && (auth()->id() == $post->id_user || auth()->user()->role == 'admin'))
        <div class="relative" x-data="{ open: false }" x-on:click.away="open = false">
          <button class="w-5" x-on:click="open = true">
            @include('icon.menu')
          </button>
          <div
            class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded flex flex-col w-48 shadow-aroundShadow"
            x-cloak x-transition x-show="open">
            <form id="delete-post-form-{{ $post->id }}" action="/post/delete/{{ $post->id }}" method="POST"
              class="flex w-full m-0" x-on:submit.prevent="$store.confirmDialog.show(() => $el.submit())">
              @csrf
              <button type="submit"
                class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex items-center w-full gap-2">
                @include('icon.delete')
                  Delete
                </button>
            </form>
          </div>
        </div>
      @endif
    </div>
    <p class="line-clamp-3">{!! nl2br(e($post->post)) !!}</p>
    <p class="w-full flex justify-end items-center text-sm gap-x-2">
      <a href="{{ $post->user->username }}"
        class="hover:text-primary hover:transition-all hover:duration-150 flex gap-1 justify-center items-center h-[30px]">
        @if (isset($post->user->image))
          <img class="rounded-full" src="/assets/profile/{{ $post->user->image }}" alt="Profile picture" width="30">
        @else
          @include('icon.user')
        @endif
        {{ $post->user->username }}
      </a>
      <span>|</span>
      <span> {{ $post->created_at->diffForHumans() }} </span>
    </p>
  </div>
@endforeach
