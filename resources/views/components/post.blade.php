@foreach ($posts as $post)
  <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
    <div class="flex justify-between items-center">
      <a class="text-xl w-max hover:text-primary hover:transition-all hover:duration-150"
        href="/post/detail/{{ $post->id }}">{{ $post->title }}</a>
      @if (auth()->check())
        @if (auth()->id() == $post->id_user || auth()->user()->role == 'admin')
          <div class="relative">
            <button id="btn-dropdown-post-{{$post->id}}" class="w-5" onclick="return showDropdown('post-{{$post->id}}')">
              <img src="/images/menu.svg" alt="menu" width="30">
            </button>
            <div id="dropdown-menu-post-{{$post->id}}"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded hidden flex-col w-48 shadow-aroundShadow">
              <form id="delete-post-form-{{ $post->id }}" action="/comment/delete/{{ $post->id }}"
                method="POST" class="flex w-full m-0" onsubmit="return confirmPost({{ $post->id }})">
                @csrf
                <button type="submit"
                  class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex w-full gap-2"><img
                    src="/images/delete.svg" alt="delete" width="25">Delete</button>
              </form>
            </div>
          </div>
        @endif
      @endif
    </div>
    <p class="line-clamp-3">{!! nl2br(e($post->post)) !!}</p>
    <p class="w-full flex justify-end items-center text-sm gap-x-2">
      <a href="{{ $post->user->username }}"
        class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center">
        @if (isset($post->user->image))
          <img class="rounded-full" src="/assets/profile/{{ $post->user->image }}" alt="Profile picture" width="30">
        @else
          <img class="rounded-full" src="/assets/profile/default.svg" alt="Profile picture" width="30">
        @endif
        {{ $post->user->username }}
      </a>
      <span>|</span>
      <span> {{ $post->created_at->diffForHumans() }} </span>
    </p>
  </div>
@endforeach

<script>
  function confirmPost(id) {
    event.preventDefault();
    return showConfirm(function() {
      document.getElementById('delete-post-form-' + id).submit();
    }, "You won't be able to revert this!", "yes, Delete it!")
  }
</script>
