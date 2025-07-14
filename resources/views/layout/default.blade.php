<!DOCTYPE html>
<html class="dark" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
  <style>
    [x-cloak] {display: none !important}
  </style>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>@yield('title', 'Discussion')</title>
</head>

<body class="flex min-h-screen bg-ccblack text-ccwhite" x-data="">

  {{-- bagian popup --}}
  @if (session('alert'))
    @include('components.alert', [
        'type' => session('alert')['type'],
        'message' => session('alert')['message'],
    ])
  @endif
  @include('components.popup-confirm')

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

</html>
