@extends('layout.default')
@section('title', 'Edit Post')
@section('script')
  @vite(['resources/js/addPost.js'])
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)]  p-4">
    <div class="flex flex-wrap w-full">
      <h1 class="text-2xl w-full mb-4">Add post</h1>

      <div class="w-full card bg-base-100 border border-gray-500">
        <div class="card-body p-2">
          <form action="{{ route('post-update') }}" method="post" enctype="multipart/form-data" id="sendForm"
            class="grid grid-cols-4 justify-start items-center gap-4 p-4">
            @csrf
            <input type="hidden" name="id" value="{{ $post->id }}">
            <input type="hidden" name="remove_image" id="removeImageInput" value="0">
            <div class="col-span-4 md:col-span-1">
              <label for="image" class="label mb-1">Image (optional)</label>
              <div class="relative">
                <label for="image" class="cursor-pointer block">
                  <div class="w-full min-h-25 overflow-hidden">
                    {{-- Tampilkan default SVG --}}
                    <div id="defaultSvg"
                      class="border border-dashed border-gray-500 w-full h-32 flex items-center justify-center rounded-lg {{ $post->image ? 'hidden' : '' }}">
                      <div class="flex flex-col items-center text-gray-400">
                        <x-phosphor-image-square class="w-10 h-10" />
                        <span class="text-xs">Click to upload</span>
                      </div>
                    </div>
                    {{-- Kita siapkan img kosong untuk preview upload nanti --}}
                    <img id="imagePreview" src="{{ $post->image ? asset('storage/posts/' . $post->image) : '' }}"
                      class="{{ $post->image ? '' : 'hidden' }} object-cover rounded w-full h-full" alt="Preview">
                  </div>

                  <span class="absolute inset-0 bg-black/50 rounded opacity-0 hover:opacity-100 transition-all"></span>
                </label>
                <input type="file" name="image" id="image" class="hidden">
              </div>
              <button type="button" id="btnRemoveImage" class="btn btn-error btn-sm mt-2 w-full">Remove Image</button>
            </div>
            <div class="col-span-4 md:col-span-3">
              <div class="w-full flex flex-col">
                <label for="title" class="label mb-1">Title</label>
                <input type="text" name="title" id="title" class="input w-full" placeholder="Enter Title Here"
                  value="{{ $post->title }}">
              </div>
            </div>
            <div class="w-full col-span-4 flex flex-col">
              <label for="content" class="label mb-1">Content</label>
              <textarea type="text" name="post" id="content" class="textarea w-full resize-none autoWrap" rows="3"
                placeholder="Enter Content Here">{{ $post->content }}</textarea>
            </div>
            <div class="w-full col-span-4 flex flex-col mb-2">
              <label for="tags" class="label mb-1">Tags (optional)</label>
              <input name="tags" id="tags" class="tagify-input w-full" placeholder="Add tags (press Enter)" value="{{ $post->tags->pluck('name')->implode(',') }}">
              <label class="label">
                <span class="label-text-alt text-gray-500 italic">User-generated tags help others find your post. (max 10
                  tags)</span>
              </label>
            </div>
            <div class="w-full col-span-4 flex justify-end">
              <button type="button" onclick="validate()" class="btn btn-primary w-full md:w-35">Save</button>
            </div>
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

    document.getElementById('image').addEventListener('change', (e) => {
      document.getElementById('removeImageInput').value = "0";
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          // Hilangkan SVG default kalau ada
          const defaultSvg = document.getElementById('defaultSvg');
          if (defaultSvg) defaultSvg.classList.add('hidden');

          // Tampilkan img preview
          const imgPreview = document.getElementById('imagePreview');
          imgPreview.classList.remove('hidden');
          imgPreview.src = evt.target.result;
        }
        reader.readAsDataURL(file);
      }
    });

    document.getElementById('btnRemoveImage')?.addEventListener('click', function() {
      $('#imagePreview').addClass('hidden');
      $('#defaultSvg').removeClass('hidden');
      $('#removeImageInput').val(1);
      $('#image').val('');
      // this.classList.add('hidden');
    })
  </script>
@endsection
