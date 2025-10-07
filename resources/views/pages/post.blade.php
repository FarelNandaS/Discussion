@extends('layout.default')
@section('title', 'post')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]  p-4">
    @if (!empty(session('error')))
        @include('components.error-massage', ['error'=>session('error')])
    @endif
    <form action="{{route('post-save')}}" method="post" id="sendForm" class="w-full h-auto flex flex-col justify-start items-start gap-4 p-4 rounded">
      @csrf
      <h1 class="text-2xl">Add post</h1>
      <div class="w-full flex flex-col">
        <label for="title">Title</label>
        <textarea type="text" name="title" id="title"
          class="rounded bg-ccblack w-full overflow-hidden resize-none p-2 border autoWrap" rows="1"></textarea>
      </div>
      <div class="w-full flex flex-col">
        <label for="post">Post</label>
        <textarea type="text" name="post" id="post"
          class="rounded bg-ccblack w-full overflow-hidden resize-none p-2 border autoWrap" rows="3"></textarea>
      </div>
      <button type="button" onclick="validate()" class="text-xl text-black bg-light w-[100px] p-2 rounded hover:bg-darker hover:text-ccwhite hover:transition-all hover:duration-150">Post</button>
    </form>
  </main>

  <script>
    const textarea = document.getElementById('title');
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });
    const textarea2 = document.getElementById('post');
    textarea2.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });
    
    function validate() {
      let title = $('textarea[name="title"]').val();
      let post = $('textarea[name="post"]').val();

      if (title == '') {
        showAlert('error', 'The title is required');
      } else if (post == '') {
        showAlert('error', 'The post is required')
      } else {
        $('#sendForm').submit();
      }
    }
  </script>
@endsection
