@extends('layout.default')
@section('title', 'Tags')
@section('script')
  @vite(['resources/js/tags.js'])
@endsection
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

      <div class="gap-4">
        @if (!empty($tags))
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="tagContainer">
            @include('components.tag', $tags)
          </div>

          <div id="load_more_status" class="flex justify-center py-4">
            <div id="loading_spinner" class="loading loading-dots loading-md hidden"></div>
          </div>
        @else
          <div class="col-span-full flex flex-col items-center justify-center py-20 opacity-40">
            <x-tabler-tag-off class="w-20 h-20 mb-4" />
            <p class="text-xl font-bold">No tags found yet.</p>
          </div>
        @endif
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
