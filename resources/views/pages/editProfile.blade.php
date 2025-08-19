@extends('layout.default')
@section('title', 'Edit Profile')
@section('main')
<<<<<<< HEAD
  <main class="w-full min-h-[calc(100vh-60px)] p-4 gap-4 flex flex-col">
=======
  <main class="w-full min-h-[calc(100vh-60px)] border-l border-gray-600 p-4 gap-4 flex flex-col">
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
    <h1 class="text-2xl">Edit Your Profile</h1>
    <form action="/profile/update" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 max-w-full">
      @csrf
      <div class="flex items-center justify-center gap-4 w-full">
<<<<<<< HEAD
        <div class="relative">
          <label for="image" class="cursor-pointer">
            <img src="{{ $user->image ? '/assets/profile/' . $user->image : '/assets/profile/default.svg' }}"
              alt="Profile Picture" width="100" height="100" class="object-cover rounded-full" id="imagePreview">
              <span class="absolute inset-0 bg-black/50 rounded-full opacity-0 hover:opacity-100 transition-all"></span>
          </label>
          <input type="file" name="image" id="image" class="hidden">
=======
        <div class="relative" x-data="{
        preview: null,

        cropAndPreviewImage(e) {
          const file = e.target.files[0];
          if (!file) return;

          const reader = new FileReader();
          reader.onload = (evt) => {
            const img = new Image();
            img.onload = () => {
              const size = Math.min(img.width, img.height);
              const offsetX = (img.width - size) / 2;
              const offsetY = (img.height - size) / 2;

              const canvas = document.createElement('canvas');
              canvas.width = 500;
              canvas.height = 500;
              const ctx = canvas.getContext('2d');

              ctx.drawImage(img, offsetX, offsetY, size, size, 0, 0, 500, 500);

              const croppedDataURL = canvas.toDataURL('image/png');
              this.preview = croppedDataURL;

              fetch(croppedDataURL)
                .then(res => res.blob())
                .then(blob => {
                  const croppedFile = new File([blob], file.name, {type: blob.type});
                  const dt =  new DataTransfer();
                  dt.items.add(croppedFile);
                  this.$refs.fileInput.files = dt.files;
                });
            }
            img.src = evt.target.result;
          }
          reader.readAsDataURL(file);
        }
        }">
          <label for="image" class="cursor-pointer">
            <img :src="preview || '{{ $user->image ? '/assets/profile/' . $user->image : '/assets/profile/default.svg' }}' "
              alt="Profile Picture" width="100" height="100" class="object-cover rounded-full" id="imagePreview">
              <span class="absolute inset-0 bg-black/50 rounded-full opacity-0 hover:opacity-100 transition-all"></span>
          </label>  
          <input type="file" name="image" id="image" class="hidden" x-ref="fileInput" x-on:change="cropAndPreviewImage">
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
        </div>
        <div class="flex flex-col w-full">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" value="{{ $user->username }}"
            class="bg-transparent border-b">
        </div>
      </div>
      <div class="flex flex-col">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="{{ $user->email }}"
          class="bg-transparent border-b min-w-[100px]">
      </div>
      <div class="flex flex-col">
        <label for="info">Bio</label>
        <input type="text" name="info" id="info" value="{{ $user->info }}" class="bg-transparent border-b">
      </div>
      <div class="flex flex-col">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="bg-transparent border-b text-ccwhite" class="bg-transparent">
          <option value="" class="text-ccblack">-- Pilih --</option>
          <option value="Male" class="text-ccblack" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
          <option value="Female" class="text-ccblack" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
      </div>
      <button type="submit"
        class="bg-light text-ccblack p-2 rounded duration-150 transition-all hover:bg-primary hover:text-ccwhite hover:duration-150 hover:transition-all">Update</button>
    </form>
  </main>
<<<<<<< HEAD

  <script>
    document.getElementById('image').addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          document.getElementById('imagePreview').src = evt.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
=======
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
@endsection
