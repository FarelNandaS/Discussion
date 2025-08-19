<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<<<<<<< HEAD
  <title>@yield('title', 'My App')</title>
=======
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
  <style>
    [x-cloak] {display: none !important}
  </style>
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<<<<<<< HEAD
<body class="flex min-h-screen bg-ccwhite dark:bg-ccblack dark:text-ccwhite">

  {{-- Popup & Alert Global --}}
=======
<body class="flex min-h-screen bg-ccblack text-ccwhite" x-data="">

  {{-- bagian popup --}}
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
  @if (session('alert'))
    @include('components.alert', [
        'type' => session('alert')['type'],
        'message' => session('alert')['message'],
    ])
  @endif
  @include('components.popup-confirm')

<<<<<<< HEAD
  {{-- Layout Container --}}
  <div class="flex w-full">
    
    {{-- Sidebar --}}
    <aside class="w-[13%] fixed h-full bg-gray-100 dark:bg-ccdark">
      @include('components.sidebar')
    </aside>

    {{-- Main Content --}}
    <main class="w-[87%] ml-[13%] min-h-screen flex flex-col">
      @include('components.navbar')

      <div class="flex-1">
        @yield('main')
      </div>

      @include('components.footer')
    </main>
  </div>

  {{-- Scripts --}}
  @livewireScripts
  <script>
    var btnDropdown = null;
    var dropdownMenu = null;
=======
  {{-- bagian body --}}
  <div class="w-screen flex flex-col bg-ccwhite text-ccblack dark:bg-ccblack dark:text-ccwhite">
    <div class="flex">
      @include('components.sidebar')
      <div class="flex-1 flex flex-col">
        @include('components.navbar')
        @yield('main')
      </div>
    </div>
    @include('components.footer')
  </div>

  {{-- bagian script --}}
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('confirmDialog', {
        open: false,
        message: 'You won\'t be able to revert this!',
        btnText: 'yes, delete it!',
        callback: () => {},

        show(callback, message = 'You won\'t be able to revert this!', btnText = 'yes, delete it!') {
          this.message = message;
          this.btnText = btnText;
          this.callback = callback;
          this.open = true;
        },

        confirmAction() {
          this.callback();
          this.open = false;
        }
      });
    })
  </script>
</body>
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c

    function showDropdown(uniqName) {
      if (btnDropdown != null && dropdownMenu != null) return;

      btnDropdown = document.getElementById("btn-dropdown-" + uniqName)
      dropdownMenu = document.getElementById("dropdown-menu-" + uniqName)

      dropdownMenu.classList.remove('hidden');
      dropdownMenu.classList.add('flex')
    }

    document.addEventListener('click', function(e) {
      if (!btnDropdown?.contains(e.target) && btnDropdown != null && dropdownMenu != null) {
        dropdownMenu.classList.remove('flex');
        dropdownMenu.classList.add('hidden');
        btnDropdown = null;
        dropdownMenu = null;
      }
    })
  </script>
</body>
</html>
