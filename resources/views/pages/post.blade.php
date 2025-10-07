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
        <input type="text" name="title" id="title" class="input w-full" placeholder="Enter Title Here">
      </div>
      <div class="w-full flex flex-col">
        <label for="post">Post</label>
        <textarea type="text" name="post" id="post"
          class="textarea w-full resize-none autoWrap" rows="3" placeholder="Enter Post Here"></textarea>
      </div>
      <button type="button" onclick="validate()" class="btn btn-primary">Post</button>
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
