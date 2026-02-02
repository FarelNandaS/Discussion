@foreach ($comments as $comment)
  <div class="group flex gap-3 p-4 bg-base-100 border rounded-lg border-gray-500 hover:bg-base-200/30 transition-colors">

    {{-- Avatar --}}
    <div class="flex-shrink-0">
      <a href="{{ route('profile', ['username' => $comment->user->username]) }}" class="avatar">
        <div class="w-10 h-10 rounded-full border border-base-300">
          @if (isset($comment->user->detail->image))
            <img src="{{ asset('storage/profile/' . $comment->user->detail->image) }}" alt="Avatar" />
          @else
            <div class="bg-base-300 w-full h-full flex items-center justify-center">
              <x-tabler-user-circle class="text-gray-400 w-full h-full" />
            </div>
          @endif
        </div>
      </a>
    </div>

    {{-- Content Area --}}
    <div class="flex-grow space-y-1">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <a href="{{ route('profile', ['username' => $comment->user->username]) }}"
            class="font-bold text-sm hover:underline">
            {{ $comment->user->username }}
            @if ($comment->user->hasRole('Admin') || $comment->user->hasRole('Super Admin'))
              <x-eos-admin style="width: 20px; height: 20px;" class="tooltip" data-tip="Admin" />
            @endif
          </a>
          <span class="text-[10px] opacity-40">•</span>
          <span class="text-xs opacity-50">{{ $comment->created_at->diffForHumans() }}</span>
        </div>

        {{-- Dropdown Actions --}}
        @if (auth()->check())
          <div class="dropdown dropdown-end">
            <button tabindex="0" class="btn btn-ghost btn-xs btn-circle">
              <x-tabler-dots class="w-4 h-4" />
            </button>
            <ul tabindex="0"
              class="dropdown-content menu p-1 shadow-xl bg-base-200 rounded-box w-32 border border-gray-500 z-[10]">
              @if (auth()->id() == $comment->id_user || auth()->user()->hasRole('Super Admin'))
                <li>
                  <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comment-delete') }}"
                    method="POST" onsubmit="return confirmComment({{ $comment->id }})">
                    @csrf
                    <input type="hidden" value="{{ $comment->id }}" name="id">
                    <button type="submit" class="text-error flex items-center gap-2">
                      <x-tabler-trash class="w-5 h-5" /> Delete
                    </button>
                  </form>
                </li>
              @else
                <li>
                  <button onclick="showReport('comment', {{ $comment->id }})" class="">
                    <x-tabler-flag class="w-5 h-5" /> Report
                  </button>
                </li>
              @endif
            </ul>
          </div>
        @endif
      </div>

      {{-- Comment Text --}}
      <div class="text-sm text-base-content/80 leading-relaxed break-words">
        {!! nl2br(e($comment->content)) !!}
      </div>
    </div>
  </div>
@endforeach
