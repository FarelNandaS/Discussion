<button wire:click="toggleFollow" class="border border-gray-500 rounded-full px-4 text-base h-full hover:bg-gray-500 hover:transition-all hover:duration-150">
  @if ($isFollowing)
    Unfollow
@else
    follow
  @endif
</button>
