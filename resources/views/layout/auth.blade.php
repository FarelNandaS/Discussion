<!DOCTYPE html>
<html data-theme="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="shortcut icon" href="{{ asset('images/logo_primary.png') }}" type="image/png">
  <title>@yield('title', 'authentication')</title>
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
