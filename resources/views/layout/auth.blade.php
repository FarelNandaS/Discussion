<!DOCTYPE html>
<html data-theme="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="shortcut icon" href="{{ asset('images/logo_primary.png') }}" type="image/png">
  <title>@yield('title', 'authentication')</title>

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

<body class="min-h-screen flex flex-col justify-center items-center bg-[#272727] gap-8">
  @include('components.alert')
  @yield('main')
</body>

<script>
  @if (session('alert'))
    showAlert("{{ session('alert')['type'] }}", "{{ session('alert')['message'] }}")
  @endif
</script>

</html>
