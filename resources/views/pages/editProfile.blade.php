@extends('layout.default')
@section('title', 'Edit Profile')
@section('script')
  @vite(['public\assets\js\editProfile.js'])
@endsection
@section('main')
  <main class="w-full min-h-[calc(100vh-60px)] p-4 gap-4 flex flex-col">
    <h1 class="text-2xl">Edit Your Profile</h1>
    <form action="/profile/update" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 max-w-full">
      @csrf
      <div class="flex items-center justify-center gap-4 w-full">
        <div class="relative">
          <label for="image" class="cursor-pointer block">
            <div class="w-[100px] h-[100px] overflow-hidden rounded-full">
              @if (isset($user->detail->image))
                {{-- Tampilkan foto user --}}
                <img src="{{ asset('storage/profile/' . $user->detail->image) }}" alt="Profile Picture"
                  class="object-cover w-full h-full rounded-full" id="imagePreview">
              @else
                {{-- Tampilkan default SVG --}}
                <div id="defaultSvg">
                  {!! file_get_contents(public_path('Images/detailDefault.svg')) !!}
                </div>
                {{-- Kita siapkan img kosong untuk preview upload nanti --}}
                <img id="imagePreview" class="hidden object-cover w-full h-full rounded-full" alt="Preview">
              @endif
            </div>
            <span class="absolute inset-0 bg-black/50 rounded-full opacity-0 hover:opacity-100 transition-all"></span>
          </label>
          <input type="file" name="image" id="image" class="hidden">
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
        class="btn btn-primary duration-150 transition-all hover:btn-secondary hover:duration-150 hover:transition-all">Update</button>
    </form>
  </main>

  <script>
    document.getElementById('image').addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
          // Hilangkan SVG default kalau ada
          const defaultSvg = document.getElementById('defaultSvg');
          if (defaultSvg) defaultSvg.style.display = 'none';

          // Tampilkan img preview
          const imgPreview = document.getElementById('imagePreview');
          imgPreview.classList.remove('hidden');
          imgPreview.src = evt.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
@endsection
