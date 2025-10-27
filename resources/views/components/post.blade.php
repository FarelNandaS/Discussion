@foreach ($posts as $post)
  <div class="flex flex-col gap-4 border-b border-gray-600 py-4">
    <div class="flex items-center">
      <a class="text-xl w-max hover:text-primary hover:transition-all hover:duration-150"
        href="/post/detail/{{ $post->id }}">{{ $post->title }}</a>
    </div>
    <h5 class="line-clamp-3">{!! nl2br(e($post->content)) !!}</h5>
    <p class="w-full flex justify-end items-center text-sm gap-x-2">
      <a href="{{ route('profile', ['username'=>$post->user->username]) }}"
        class="hover:text-primary hover:transition-all hover:duration-150 flex gap-2 justify-center items-center">
        <span class="w-[30px] h-[30px] flex-grow-0 flex-shrink-0 overflow-hidden">
          @if (isset($post->user->detail->image))
            <img class="rounded-full object-cover w-full h-full" src="{{ asset('storage/profile/' . $post->user->detail->image ) }}"
              alt="Profile picture" width="30">
          @else
            {!! file_get_contents(public_path('Images/default.svg')) !!}
          @endif
        </span>
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
      $('#delete-post-form-' + id).submit();
    }, "You won't be able to revert this!", "yes, Delete it!")
  }
</script>
