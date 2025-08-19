<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title', 'My App')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="flex min-h-screen bg-ccwhite dark:bg-ccblack dark:text-ccwhite">

  {{-- Popup & Alert Global --}}
  @if (session('alert'))
    @include('components.alert', [
        'type' => session('alert')['type'],
        'message' => session('alert')['message'],
    ])
  @endif
  @include('components.popup-confirm')

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
