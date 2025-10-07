<!DOCTYPE html>
<html data-theme="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="{{ asset('images/logo_primary.png') }}" type="image/png">
  <title>@yield('title', 'My App')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="flex min-h-screen">

  {{-- Popup & Alert Global --}}
  @include('components.alert')
  @include('components.modal-dialog')

  {{-- Layout Container --}}
  <div class="drawer lg:drawer-open">
    {{-- Toggle --}}
    <input id="drawer-sidebar" type="checkbox" class="drawer-toggle" />

    {{-- Konten Utama --}}
    <div class="drawer-content flex flex-col lg:ml-52 border-l border-gray-500">
      {{-- Navbar --}}
      @include('components.navbar')

      {{-- Main Content --}}
      <main class="flex-1">
        @yield('main')
      </main>

      @include('components.footer')
    </div>

    {{-- Sidebar --}}
    <div class="drawer-side">
      <label for="drawer-sidebar" class="drawer-overlay"></label>
      @include('components.sidebar')
    </div>
  </div>

  {{-- Scripts --}}
  @livewireScripts
  <script>
    @if (session('alert'))
      showAlert("{{ session('alert')['type'] }}", "{{ session('alert')['message'] }}")
    @endif

    var btnDropdown = null;
    var dropdownMenu = null;

    function showDropdown(uniqName) {
      if (btnDropdown != null && dropdownMenu != null) return;

      btnDropdown = $("#btn-dropdown-" + uniqName)
      dropdownMenu = $("#dropdown-menu-" + uniqName)

      dropdownMenu.removeClass('hidden').addClass('flex');
    }

    document.addEventListener('click', function(e) {
      if (btnDropdown !== null &&
        dropdownMenu !== null &&
        !btnDropdown.is(e.target) &&
        btnDropdown.has(e.target).length === 0) {
        dropdownMenu.removeClass('flex').addClass('hidden');
        btnDropdown = null;
        dropdownMenu = null;
      }
    })
  </script>
</body>

</html>
