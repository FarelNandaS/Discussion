@extends('layout.default')
@section('title', "Let's Discuss")

@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4">
    @if ($posts['recommendation'] && $posts['recommendation']->count())
      <div class="flex justify-between items-center border-b border-gray-500 mb-4 pb-4">
        <h1 class="text-2xl font-bold">Recommendation Posts</h1>
        <input type="date" name="sortDate" id="sortDate" class="input">
      </div>
      @include('components.post', ['posts' => $posts['recommendation']])
    @else
      <div class="flex justify-center items-center flex-col gap-4 py-20 w-full">
        <div class="opacity-40">
          {!! file_get_contents(public_path('images/not-found.svg')) !!}
        </div>
        <div class="text-center">
          <h1 class="text-2xl font-bold opacity-80">There are no posts yet.</h1>
          <p class="text-gray-500">Be the first to share your story or thoughts today!</p>
        </div>
      </div>
    @endif
  </main>

  <script>
    // document.getElementById('sortDate').addEventListener('change', function () {
    //   const val = this.value;
    //   const posts = document.querySelectorAll('.postCard');

    //   posts.forEach(post => {
    //     const postDate = post.getAttribute('data-date');
    //     console.log(postDate);
    //     console.log(val);

    //     if (val == '' || postDate == val) {
    //       post.style.display = 'block'
    //     } else {
    //       post.style.display = 'none'
    //     }
    //   })
    // })
  </script>
@endsection
