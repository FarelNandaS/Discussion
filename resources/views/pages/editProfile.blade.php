@extends('layout.default')
@section('title', 'Edit Profile')
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4 gap-4 flex flex-col">
    <h1 class="text-2xl">Edit Your Profile</h1>
    <form action="/profile/update" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 max-w-full">
      @csrf
      <div class="flex items-center justify-center gap-4 w-full">
        <div class="relative">
          <label for="image" class="cursor-pointer">
            <img src="{{ $user->image ? '/assets/profile/' . $user->image : '/assets/profile/default.svg' }}"
              alt="Profile Picture" width="100" height="100" class="object-cover rounded-full" id="imagePreview">
              <span class="absolute inset-0 bg-black/50 rounded-full opacity-0 hover:opacity-100 transition-all"></span>
          </label>
          <input type="file" name="image" id="image" class="hidden">
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
@endsection
