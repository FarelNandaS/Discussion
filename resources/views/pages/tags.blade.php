@extends('layout.default')
@section('title', 'Tags')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="max-w-6xl mx-auto">

      <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
          <h1 class="text-4xl font-black tracking-tight italic flex items-center gap-3">
            Explore Topics
          </h1>
          <p class="text-base-content/60 mt-2">Discover interesting posts through community-generated tags.</p>
        </div>

        <div class="form-control w-full md:w-80">
          <div class="relative">
            <input type="text" id="searchTag" placeholder="Filter tags..."
              class="input input-bordered w-full pl-10 rounded-2xl focus:input-primary transition-all shadow-sm" />
            <x-tabler-search class="absolute left-3 top-3 w-5 h-5 opacity-40" />
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="tagContainer">
        @forelse($tags as $tag)
          <a href="{{ route('tag-post', ['slug'=>$tag->slug]) }}"
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
        @empty
          <div class="col-span-full flex flex-col items-center justify-center py-20 opacity-40">
            <x-tabler-tag-off class="w-20 h-20 mb-4" />
            <p class="text-xl font-bold">No tags found yet.</p>
          </div>
        @endforelse
      </div>
    </div>
  </main>

  <script>
    document.getElementById('searchTag').addEventListener('input', function(e) {
      let filter = e.target.value.toLowerCase();
      let cards = document.querySelectorAll('#tagContainer a');

      cards.forEach(card => {
        let tagName = card.querySelector('h2').textContent.toLowerCase();
        if (tagName.includes(filter)) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      });
    });
  </script>
@endsection
