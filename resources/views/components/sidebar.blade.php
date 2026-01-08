<?php
$currentRoute = Route::currentRouteName();
?>

<div class="menu p-0 w-52 min-h-screen bg-primary text-white fixed">
  <h1 class="text-2xl font-bold flex justify-center items-center m-4">
    <a href="{{ route('home') }}">Let's Discuss</a>
  </h1>

  <ul class="flex flex-col mt-6">
    <li>
      <a href="{{ route('home') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg {{ str_contains($currentRoute, 'home') ? 'menu-active' : '' }}">
        <x-tabler-home style="width: 25px;"/> Home
      </a>
    </li>
    <li>
      <a href="{{ route('newest') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg {{ str_contains($currentRoute, 'newest') ? 'menu-active' : '' }}">
        <x-heroicon-o-chat-bubble-left-ellipsis style="width: 25px;"/> Newest
      </a>
    </li>
    <li>
      <a href="{{ route('saved') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg {{ str_contains($currentRoute, 'saved') ? 'menu-active' : '' }}">
        <x-tabler-bookmark style="width: 25px;"/> Saved
      </a>
    </li>
  </ul>

  <ul class="mt-10">
    <li>
      <a href="{{ route('post-add') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg {{ str_contains($currentRoute, 'post-add') ? 'menu-active' : '' }}">
        <x-tabler-circle-plus style="width: 25px;"/> Add Post
      </a>
    </li>
    @if (auth()->check())
      <li>
        <a href="{{ route('settings') }}"
          class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg {{ str_contains($currentRoute, 'settings') ? 'menu-active' : '' }}">
          <x-tabler-settings style="width: 25px;"/> Settings
        </a>
      </li>
    @endif
  </ul>
</div>
