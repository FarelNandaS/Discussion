@foreach ($comments as $comment)
  <div class="flex flex-col border border-gray-500 bg-base-100 rounded p-4 gap-2 mb-4">
    <div class="flex justify-between items-center">
      <a href="{{route('profile', ['username'=>$comment->user->username])}}"
        class="flex items-center gap-2 hover:text-primary hover:transition-all hover:duration-150">
        @if (isset($comment->user->detail->image))
        <span class="w-[50px] h-[50px] overflow-hidden rounded-full">
          <img src="{{ asset('storage/profile/' . $comment->user->detail->image ) }}" alt="Profile picture" class="rounded-full object-cover w-full h-full">
        </span>
        @else
          {!! file_get_contents(public_path('Images/default.svg')) !!}
        @endif
        {{ $comment->user->username }}
      </a>
      @if (auth()->check())
        @if (auth()->id() == $comment->id_user || auth()->user()->role == 'admin')
          <div class="dropdown dropdown-end">
            <button class="w-5" role="button" tabindex="0">
              {!! file_get_contents(public_path('images/menu.svg')) !!}
            </button>
            <ul tabindex="0" class="dropdown-content menu border border-gray-500 w-48 rounded p-0 bg-base-200">
              <li>
                <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comment-delete') }}" method="POST"
                  class="flex w-full m-0 p-0" onsubmit="return confirmComment({{ $comment->id }})">
                  @csrf
                  <input type="text" class="hidden" value="{{ $comment->id }}" name="id">
                  <button type="submit"
                    class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex w-full gap-2">
                    {!! file_get_contents(public_path('images/delete.svg')) !!}Delete
                  </button>
                </form>
              </li>
            </ul>
          </div>
          {{-- <div class="relative">
            <button id="btn-dropdown-comments-{{ $comment->id }}" class="w-5"
              onclick="return showDropdown('comments-{{ $comment->id }}')">
              {!! file_get_contents(public_path('images/menu.svg')) !!}
            </button>
            <div id="dropdown-menu-comments-{{ $comment->id }}"
              class="absolute bg-ccblack border border-gray-500 right-0 top-0 rounded hidden flex-col w-48 shadow-aroundShadow">
              <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comment-delete') }}" method="POST"
                class="flex w-full m-0" onsubmit="return confirmComment({{ $comment->id }})">
                @csrf
                <input type="text" class="hidden" value="{{ $comment->id }}" name="id">
                <button type="submit"
                  class="hover:bg-gray-500 hover:transition-all hover:duration-150 p-2 flex w-full gap-2"><img
                    src="/images/delete.svg" alt="delete" width="25">Delete</button>
              </form>
            </div>
          </div> --}}
        @endif
      @endif
    </div>
    <p>{!! nl2br(e($comment->content)) !!}</p>
    <div class="flex w-full justify-end">
      <p>{{ $comment->created_at->diffForHumans() }}</p>
    </div>
  </div>
@endforeach

<script>
  function confirmComment(id) {
    event.preventDefault();
    return showConfirm(function() {
      $('#delete-comment-form-' + id).submit();
    }, "You won't be able to revert this!", "yes, Delete it!")
  }
</script>
