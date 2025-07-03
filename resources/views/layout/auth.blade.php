<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>@yield('title', 'authentication')</title>
</head>

<body class="min-h-screen flex flex-col justify-center items-center bg-[#272727] gap-8">
  @if (session('alert'))
    @include('components.alert', [
        'type' => session('alert')['type'],
        'message' => session('alert')['message'],
    ])
  @endif
  @yield('main')
</body>

</html>
