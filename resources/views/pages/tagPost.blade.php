@extends('layout.default')
@section('title', 'Tag ' . $tag->name)
@section('script')
    @vite('resources/js/tagPost.js')
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] min-w-full p-4">
      @if ($posts && $posts->count())
        {{-- Tag Hero Header --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-10 pb-6 border-b border-gray-500">
          <div class="flex items-center gap-4">
            <div class="bg-primary text-primary-content p-4 rounded-2xl shadow-lg">
              <x-tabler-hash class="w-10 h-10" />
            </div>
            <div>
              <h1 class="text-3xl font-black italic tracking-tight mb-2">{{ $tag->name }}</h1>
              <p class="text-sm text-base-content/60">
                Showing <span class="font-bold text-base-content">{{ $posts->count() }}</span> posts categorized in this
                topic
              </p>
            </div>
          </div>

          <input type="date" name="sortDate" id="sortDate" class="input">
          {{-- <a href="{{ route('tags') }}" class="btn btn-ghost btn-sm gap-2">
            <x-tabler-arrow-left class="w-4 h-4" /> Back to tags
          </a> --}}
        </div>

        {{-- Post Container --}}
        <div id="post_container" data-key="{{ $tag->name }}" class="space-y-6">
          @include('components.post', ['posts' => $posts])
        </div>

        {{-- Loading State --}}
        <div id="load_more_status" class="flex justify-center py-10">
          <div id="loading_spinner" class="loading loading-dots loading-lg text-primary hidden"></div>
        </div>
      @else
        {{-- Not Found State --}}
        <div
          class="flex justify-center items-center flex-col gap-6 py-24 w-full bg-base-200/30 rounded-3xl border-2 border-dashed border-base-300">
          <div class="opacity-20 w-40">
            {!! file_get_contents(public_path('images/not-found.svg')) !!}
          </div>
          <div class="text-center">
            <h1 class="text-3xl font-black opacity-80">Topic is Empty</h1>
            <p class="text-base-content/50 max-w-xs mx-auto">Looks like no one has written about <span
                class="font-bold text-primary">#{{ $tag->name }}</span> yet.</p>
            <a href="/" class="btn btn-primary btn-sm mt-6 rounded-full px-8">Back Home</a>
          </div>
        </div>
      @endif
  </main>
@endsection
