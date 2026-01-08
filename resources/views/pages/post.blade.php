@extends('layout.default')
@section('title', 'Add Post')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]  p-4">
    <div class="flex flex-wrap w-full">
      <h1 class="text-2xl w-full mb-4">Add post</h1>

      <div class="w-full card bg-base-100 border border-gray-500">
        <div class="card-body p-2">
          <form action="{{route('post-save')}}" method="post" id="sendForm" class="flex flex-wrap justify-start items-start gap-4 p-4">
            @csrf
            <div class="w-full flex flex-col">
              <label for="title">Title</label>
              <input type="text" name="title" id="title" class="input w-full" placeholder="Enter Title Here">
            </div>
            <div class="w-full flex flex-col">
              <label for="content">Content</label>
              <textarea type="text" name="post" id="content"
                class="textarea w-full resize-none autoWrap" rows="3" placeholder="Enter Content Here"></textarea>
            </div>
            <button type="button" onclick="validate()" class="btn btn-primary">Post</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.querySelectorAll('.autoWrap').forEach(textarea => {
      textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
      });
    });
    
    function validate() {
      let title = $('input[name="title"]').val();
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
