@extends('layout.default')
@section('title', 'Edit Profile')
@section('script')
  @vite(['public\assets\js\editProfile.js'])
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4 gap-4 flex flex-col">
    <h1 class="text-2xl">Edit Your Profile</h1>
    <form action="/profile/update" method="POST" enctype="multipart/form-data"
      class="card border border-gray-500 bg-base-100 p-4 flex flex-col gap-4 max-w-full">
      @csrf
      <input type="hidden" name="remove_image" id="removeImageInput" value="0">
      <div class="flex items-center justify-center gap-4 w-full">
        <div class="relative flex flex-col items-center">
          <label for="image" class="cursor-pointer block relative group">
            <div
              class="w-[100px] h-[100px] overflow-hidden rounded-full border border-gray-300 flex items-center justify-center bg-gray-100 relative">

              <span
                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white text-[10px] z-10">
                CHANGE
              </span>

              <div id="defaultSvg" class="{{ isset($user->detail->image) ? 'hidden' : '' }} text-gray-400">
                <x-phosphor-user-circle style="width: 100px; height: 100px;" />
              </div>

              <img id="imagePreview"
                src="{{ isset($user->detail->image) ? asset('storage/profile/' . $user->detail->image) : '' }}"
                class="{{ isset($user->detail->image) ? '' : 'hidden' }} object-cover w-full h-full rounded-full"
                alt="Preview">
            </div>
          </label>

          <input type="file" name="image" id="image" class="hidden" accept="image/*">

          <button type="button" id="btnRemoveImage"
            class="btn btn-error btn-xs mt-2 w-full {{ isset($user->detail->image) ? '' : 'hidden' }}">
            Remove Image
          </button>
        </div>
        <div class="flex flex-col w-full">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" value="{{ $user->username }}" class="input w-full"
            placeholder="Enter username here">
        </div>
      </div>
      <div class="flex flex-col">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ $user->email }}" class="input w-full"
          placeholder="Enter email here">
      </div>
      <div class="flex flex-col">
        <label for="bio">Bio</label>
        <textarea type="text" name="bio" id="bio" class="textarea w-full" placeholder="Enter bio here">{{ $user->detail->bio }}</textarea>
      </div>
      <div class="flex flex-col">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="select w-full" aria-placeholder="Select gender here">
          <option value="">Not Set</option>
          <option value="Male" {{ $user->detail->gender == 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" {{ $user->detail->gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
      </div>
      <button type="submit"
        class="btn btn-primary duration-150 transition-all hover:btn-secondary hover:duration-150 hover:transition-all">Save</button>
    </form>
  </main>

  <script>
    document.getElementById('image').addEventListener('change', (e) => {
      document.getElementById('removeImageInput').value = "0"
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
