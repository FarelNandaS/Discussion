<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  <title>@yield('title', 'Discussion')</title>
</head>

<body class="flex min-h-screen bg-ccwhite dark:bg-ccblack dark:text-ccwhite">

  {{-- bagian popup --}}
  @if (session('alert'))
    @include('components.alert', [
        'type' => session('alert')['type'],
        'message' => session('alert')['message'],
    ])
  @endif
  @include('components.popup-confirm')


  {{-- bagian body --}}
  <div>
    @include('components.sidebar')
  </div>

  <div class="w-[87%] ml-[13%] min-h-[calc(100vh-60px)] flex flex-col">
    @include('components.navbar')
    @yield('main')
    @include('components.footer')
  </div>


  {{-- bagian script --}}
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
