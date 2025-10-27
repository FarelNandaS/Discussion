<div class="menu p-0 w-52 min-h-screen bg-base-100 fixed">
  <h1 class="text-2xl font-bold flex justify-center items-center m-4">
    <a href="{{ route('home') }}">Let's Discuss</a>
  </h1>

  <ul class="flex flex-col mt-6">
    <li>
      <a href="{{ route('home') }}" class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
        {!! file_get_contents(public_path('images/home.svg')) !!} Home
      </a>
    </li>
    <li>
      <a href="{{ route('newest') }}" class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
        {!! file_get_contents(public_path('images/new.svg')) !!} Newest
      </a>
    </li>
    <li>
      <a href="{{ route('saved') }}" class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
        {!! file_get_contents(public_path('Images/savedSidebar.svg')) !!} Saved
      </a>
    </li>
  </ul>

  <ul class="mt-10">
    <li>
      <a href="{{ route('post-add') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
        {!! file_get_contents(public_path('images/add.svg')) !!} Add Post
      </a>
    </li>
    @if (auth()->check() && auth()->user()->hasRole('Admin'))
      <li>
        <a href="{{ route('post-add') }}"
          class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
          {!! file_get_contents(public_path('images/dashboard.svg')) !!} Dashboard
        </a>
      </li>
    @endif
    <li>
      <a href="{{ route('settings') }}"
        class="flex items-center gap-2 p-2 pl-4 rounded-none lg:text-lg hover:bg-primary">
        {!! file_get_contents(public_path('images/setting.svg')) !!} Settings
      </a>
    </li>
  </ul>
</div>
