@foreach ($users as $user)
  <div class="py-4 border-b border-gray-500">
    <a class="flex gap-2 items-center hover:text-primary hover:transition-all hover:duration-150 h-7 w-fit"
      href="/{{ $user->username }}">
      @if ($user->image)
        <img src="/assets/profile/{{ $user->image }}" alt="profile picture" width="30" class="rounded-full">
      @else
        @include('icon.user')
      @endif
      {{ $user->username }}
    </a>
    {{-- <div>
      <p>
        Follower {{$user->followers->count()}}
      </p>
    </div> --}}
  </div>
@endforeach
