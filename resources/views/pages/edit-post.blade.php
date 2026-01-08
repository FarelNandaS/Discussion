@extends('layout.default')
@section('title', 'Edit Post')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]  p-4">
    <form action="{{route('post-update')}}" method="post" id="sendForm" class="w-full h-auto flex flex-col justify-start items-start gap-4 p-4 rounded">
      @csrf
      <input type="hidden" value="{{ $post->id }}" name="id">
      <h1 class="text-2xl">Edit post</h1>
      <div class="w-full flex flex-col">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="input w-full" placeholder="Enter Title Here" value="{{ $post->title }}">
      </div>
      <div class="w-full flex flex-col">
        <label for="content">Content</label>
        <textarea type="text" name="post" id="content"
          class="textarea w-full resize-none autoWrap" rows="3" placeholder="Enter Content Here">{{ $post->content }}</textarea>
      </div>
      <button type="button" onclick="validate()" class="btn btn-primary">Update Post</button>
    </form>
  </main>

  <script>
    document.querySelectorAll('.autoWrap').forEach(textarea => {
      textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
      });
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
