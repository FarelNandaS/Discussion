@foreach ($posts as $post)
  <div class="flex flex-col gap-4 rounded border border-gray-600 bg-base-100 shadow-lg p-4 my-4">
    <div class="flex items-center">
      <a class="text-xl w-max link link-hover"
        href="/post/detail/{{ $post->id }}">{{ $post->title }}</a>
    </div>
    <h5 class="line-clamp-3">{!! nl2br(e($post->content)) !!}</h5>
    <p class="w-full flex justify-end items-center text-sm gap-x-2">
      <a href="{{ route('profile', ['username'=>$post->user->username]) }}"
        class="link link-hover flex gap-1 justify-center items-center">
        <span class="w-[30px] h-[30px] flex-grow-0 flex-shrink-0 overflow-hidden items-center justify-center">
          @if (isset($post->user->detail->image))
            <img class="rounded-full object-cover w-full h-full" src="{{ asset('storage/profile/' . $post->user->detail->image ) }}"
              alt="Profile picture" width="30">
          @else
            <x-tabler-user-circle style="width: 30px; height: 30px; padding: 0;"/>
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
