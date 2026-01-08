<?php
$currentRoute = Route::currentRouteName();
?>

<div class="menu p-0 w-52 min-h-screen bg-primary text-white fixed">
  <h1 class="text-2xl font-bold flex justify-center items-center m-4">
    <a href="{{ route('home') }}">Let's Discuss</a>
  </h1>
  

  <ul class="flex flex-col mt-6">
    <li>
      <a href="{{ route('admin-dashboard') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg is-drawer-close:tooltip is-drawer-close:tooltip-right {{ str_contains($currentRoute, 'admin-dashboard') ? 'menu-active' : '' }}">
        <x-tabler-layout-dashboard style="width: 25px;"/> <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('admin-reports') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg is-drawer-close:tooltip is-drawer-close:tooltip-right {{ str_contains($currentRoute, 'admin-reports') ? 'menu-active' : '' }}">
        <x-tabler-flag  style="widows: 25px;"/> <span>Reports</span>
      </a>
    </li>
  </ul>
</div>
