<button wire:click="saves">
    @if ($isSaved)
        <img src="/images/saved.svg" alt="saved" width="30">
    @else
        <img src="/images/save.svg" alt="save" width="30">
    @endif
</button>