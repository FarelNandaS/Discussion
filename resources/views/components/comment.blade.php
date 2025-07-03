@foreach ($comments as $comment)
  <div class="flex flex-col border-b border-gray-500 py-4 gap-2">
    <div class="flex justify-between items-center">
      <a href="/{{ $comment->user->username }}"
        class="flex items-center gap-2 hover:text-primary hover:transition-all hover:duration-150">
        @if (isset($comment->user->image))
          <img src="/assets/profile/{{ $comment->user->image }}" alt="Profile picture" width="50" class="rounded-full">
        @else
          <img src="/assets/profile/default.svg" alt="Profile picture" width="50" class="rounded-full">
        @endif
        {{ $comment->user->username }}
      </a>
      @if (auth()->check())
        @if (auth()->id() == $comment->id_user || auth()->user()->role == 'admin')
          <div class="relative">
            <button id="btn-dropdown-comments-{{$comment->id}}" class="w-5" onclick="return showDropdown('comments-{{$comment->id}}')">
              <img src="/images/menu.svg" alt="menu" width="30">
            </button>
            <div id="dropdown-menu-comments-{{$comment->id}}"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded hidden flex-col w-48 shadow-aroundShadow">
              <form id="delete-comment-form-{{ $comment->id }}" action="/comment/delete/{{ $comment->id }}"
                method="POST" class="flex w-full m-0" onsubmit="return confirmComment({{ $comment->id }})">
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
    <p>{!! nl2br(e($comment->comment)) !!}</p>
    <div class="flex w-full justify-end">
      <p>{{ $comment->created_at->diffForHumans() }}</p>
    </div>
  </div>
@endforeach

<script>
  function confirmComment(id) {
    event.preventDefault();
    return showConfirm(function() {
      document.getElementById('delete-comment-form-' + id).submit();
    }, "You won't be able to revert this!", "yes, Delete it!")
  }
</script>
