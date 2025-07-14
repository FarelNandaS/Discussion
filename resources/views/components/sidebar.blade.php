<aside class="w-[225px] h-full border-gray-600 gap-8 bg-ccblack text-ccwhite">
  <h1 class="text-2xl font-bold flex justify-center items-center m-4"><a href="/">Discussion</a></h1>
  <ul class="flex flex-col mt-6">
    <li class="">
      <a href="/" class="flex gap-2 hover:bg-gray-500 p-2 pl-4">
        @include('icon.home')
        Home
      </a>
    </li>
    <li class="">
      <a href="/newest" class="flex gap-2 hover:bg-gray-500 p-2 pl-4">
        @include('icon.newest')
        Newest
      </a>
    </li>
    <li class="">
      <a href="/saved" class="flex gap-2 hover:bg-gray-500 p-2 pl-4">
        @include('icon.saved')
        Saved
      </a>
    </li>
  </ul>
  <ul class="mt-10">
    <li class="">
      <a href="/post" class="flex gap-2 hover:bg-gray-500 p-2 pl-4">
        @include('icon.add')
        Add post
      </a>
    </li>
    <li class="">
      <a href="/setting" class="flex gap-2 hover:bg-gray-500 p-2 pl-4">
        @include('icon.setting')
        Setting
      </a>
    </li>
  </ul>
</aside>
