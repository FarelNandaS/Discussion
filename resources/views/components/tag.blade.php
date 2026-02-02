@foreach ($tags as $tag)
  <a href="{{ route('tag-post', ['slug' => $tag->slug]) }}"
    class="group card bg-base-100 border border-gray-500 hover:border-primary/50 hover:shadow-xl transition-all duration-300 overflow-hidden">
    <div class="card-body p-5">
      <div class="flex justify-between items-start">
        <div class="flex flex-col">
          <h2 class="text-xl font-bold group-hover:text-primary transition-colors">
            {{ $tag->name }}
          </h2>
          <span class="text-sm opacity-50 mt-1">
            {{ $tag->posts_count ?? 0 }} {{ Str::plural('post', $tag->posts_count) }}
          </span>
        </div>
        <div
          class="bg-primary/10 text-primary p-2 rounded-xl group-hover:bg-primary group-hover:text-white transition-all">
          <x-tabler-arrow-up-right class="w-5 h-5" />
        </div>
      </div>
    </div>
  </a>
@endforeach
