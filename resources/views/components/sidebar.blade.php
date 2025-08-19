<<<<<<< HEAD
<aside class="w-[13%] fixed top-0 left-0 h-full border-r border-gray-600 bg-ccwhite dark:bg-ccblack">
  <h1 class="text-2xl font-bold flex justify-center items-center m-4">
    <a href="/" class="hover:text-primary transition">Discussion</a>
  </h1>

  <ul class="flex flex-col mt-6">
    <li>
      <a href="/" class="flex items-center gap-2 hover:bg-gray-500/30 p-2 pl-4 rounded">
        <img src="/Images/home.svg" alt="Home" width="20"> Home
      </a>
    </li>
    <li>
      <a href="/newest" class="flex items-center gap-2 hover:bg-gray-500/30 p-2 pl-4 rounded">
        <img src="/Images/new.svg" alt="Newest" width="20"> Newest
      </a>
    </li>
    <li>
      <a href="/saved" class="flex items-center gap-2 hover:bg-gray-500/30 p-2 pl-4 rounded">
        <img src="/Images/saved.svg" alt="Saved" width="20"> Saved
      </a>
    </li>
  </ul>

  <ul class="mt-10">
    <li>
      <a href="/post" class="flex items-center gap-2 hover:bg-gray-500/30 p-2 pl-4 rounded">
        <img src="/Images/add.svg" alt="Add" width="20"> Add Post
=======
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
>>>>>>> db3f44d355ad15ee29bc4fd62baae663e0e98b3c
      </a>
    </li>
  </ul>
</aside>
