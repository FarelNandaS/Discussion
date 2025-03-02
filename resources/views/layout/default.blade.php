<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>@yield('title', 'Discussion')</title>
</head>

<body class="bg-[#272727] text-white flex flex-col min-h-screen">

  @include('components.navbar')

  <div class="flex-1 w-[80%] ml-[15%] mt-[74px] p-4 min-h-[calc(100vh-73px)]">
    @include('components.sidebar')
    @yield('main')
  </div>

  @include('components.footer')
</body>

</html>
