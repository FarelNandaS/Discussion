<!DOCTYPE html>
<html data-theme="" class="" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="{{ asset('images/logo_primary.png') }}" type="image/png">
  <title>@yield('title', 'My App')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @yield('script')

  <script>
    function updateDarkClass(theme, html) {
      if (theme == "dark") html.classList.add("dark");
      else html.classList.remove("dark");
    }

    function applyTheme() {
      const theme = localStorage.getItem("theme") || "system";
      const html = document.documentElement;

      if (theme == "system") {
        const systemTheme = window.matchMedia("(prefers-color-scheme: dark)")
          .matches ?
          "dark" :
          "light";
        html.setAttribute("data-theme", systemTheme);

        updateDarkClass(systemTheme, html);
      } else {
        html.setAttribute("data-theme", theme);

        updateDarkClass(theme, html);
      }
    }

    applyTheme();
  </script>
</head>

<body class="flex min-h-screen">

  {{-- Popup & Alert Global --}}
  @include('components.alert')
  @include('components.modal-dialog')
  @include('components.report-modal')

  {{-- Layout Container --}}
  <div class="drawer lg:drawer-open">
    {{-- Toggle --}}
    <input id="drawer-sidebar" type="checkbox" class="drawer-toggle" />

    {{-- Konten Utama --}}
    <div class="drawer-content flex flex-col lg:ml-52 border-x border-gray-500 bg-base-300">
      {{-- Navbar --}}
      @if (request()->is('admin*'))
        @include('components.admin.navbar')
      @else
        @include('components.navbar')
      @endif

      {{-- Main Content --}}
      <div class="flex-1">
        @yield('main')
      </div>
    </div>

    {{-- Sidebar --}}
    <div class="drawer-side">
      <label for="drawer-sidebar" class="drawer-overlay"></label>
      @if (request()->is('admin*'))
        @include('components.admin.sidebar')
      @else
        @include('components.sidebar')
      @endif
    </div>
  </div>

  {{-- Scripts --}}
  <script>
    @if (session('alert'))
      showAlert("{{ session('alert')['type'] }}", "{{ session('alert')['message'] }}")
      console.error("{{ session('alert')['message'] }}")
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
