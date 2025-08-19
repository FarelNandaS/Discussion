<button wire:click="likes" class="flex items-center gap-2">
  @if ($isLiked)
    <img src="/images/liked.svg" alt="like" width="30">
    @else
    <img src="/images/like.svg" alt="like" width="30">
  @endif {{ $likeCount }}
</button>
