@foreach ($posts as $post)
  <div class="card bg-base-100 border border-gray-500 shadow-lg my-6">
    <div class="card-body p-5">
      
      <div class="flex justify-between items-start mb-4">
        <div class="flex items-center gap-3">
          <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="avatar">
            <div class="w-10 h-10 rounded-full ring ring-offset-base-100 ring-offset-2 ring-primary/10">
              @if (isset($post->user->detail->image))
                <img src="{{ asset('storage/profile/' . $post->user->detail->image) }}" alt="Profile" />
              @else
                <x-tabler-user-circle class="w-full h-full text-gray-400" />
              @endif
            </div>
          </a>
          <div class="flex flex-col">
            <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="font-bold hover:text-primary flex items-center gap-1">
              {{ $post->user->username }}
              @if ($post->user->hasRole('Admin'))
                <x-eos-admin class="w-4 h-4 text-blue-500" title="Admin" />
              @endif
            </a>
            <span class="text-xs text-base-content/60">{{ $post->created_at->diffForHumans() }}</span>
          </div>
        </div>
      </div>

      <div class="space-y-2">
        <a href="/post/detail/{{ $post->id }}" class="group">
          <h2 class="card-title text-xl font-bold group-hover:text-primary transition-colors">
            {{ $post->title }}
          </h2>
        </a>
        <div class="text-base-content/80 leading-relaxed line-clamp-3">
          {!! nl2br(e($post->content)) !!}
        </div>
      </div>

      <div class="card-actions flex flex-col md:flex-row justify-between mt-4 pt-4 border-t border-base-200">
        <div class="flex flex-wrap gap-1">
          @foreach ($post->tags as $tag)
            <a href="{{ route('tag-post', ['slug'=>$tag->slug]) }}" class="badge badge-primary badge-md py-3 px-4 hover:scale-105 transition-all">
              {{ $tag->name }}
            </a>
          @endforeach
        </div>
        <div class="w-full md:w-auto flex justify-end order-2">
          <a href="/post/detail/{{ $post->id }}" class="btn btn-ghost btn-sm gap-2 text-primary">
            Read More
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </a>
        </div>
      </div>

    </div>
  </div>
@endforeach
