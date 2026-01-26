@extends('layout.default')
@section('title', 'Inbox')
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2"> {{-- Membatasi lebar agar nyaman dibaca --}}
      <div class="flex w-full justify-between items-center mb-6">
        <h3 class="text-2xl font-bold">Notifications</h3>
        @if ($notifications->count() > 0)
          <form action="" method="POST">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm text-primary">Mark all as read</button>
          </form>
        @endif
      </div>

      <div class="w-full">
        <div class="card bg-base-100 shadow-sm border border-gray-500">
          <div class="divide-y divide-base-300"> {{-- Garis pemisah antar notifikasi --}}
            @if ($notifications && $notifications->count())
              @foreach ($notifications as $notification)
                <a href="{{ $notification['type'] == 'reaction' ? route('detail-post', ['id'=>$notification['content_id']]) : route('inbox-detail', ['id' => $notification->id]) }}"
                  class="p-4 hover:bg-base-200/50 transition-colors flex gap-4 {{ ($notification->read_at ?? $notification['read_at']) ? 'opacity-70' : 'border-l-4 border-primary bg-primary/5' }}">

                  {{-- Icon Berdasarkan Type --}}
                  <div class="shrink-0 flex justify-center items-center">
                    @if ($notification->data['type'] ?? '' == 'information')
                      <x-phosphor-info class="w-12 h-12" />
                    @elseif ($notification->data['type'] ?? $notification['type'] == 'reaction')
                      <x-phosphor-smiley class="w-12 h-12" />
                    @endif
                  </div>

                  {{-- Content --}}
                  <div class="grow">
                    <div class="flex justify-between items-start">
                      <h4 class="font-bold {{ ($notification->read_at ?? $notification['read_at']) ? 'text-base-content/70' : 'text-base-content' }}">
                        {{ $notification->data['title'] ?? ($notification['items_count'] > 1 ? 'Your post with title "' . $notification['title'] . '" get ' . $notification['upvotes'] . ' upvote and ' . $notification['downvotes'] . ' downvote.' : $notification['first_items']->data['title']) }}
                      </h4>
                      <span class="text-xs text-base-content/50 italic">
                        {{ $notification['created_at']->diffForHumans() }}
                      </span>
                    </div>
                    @if (isset($notification->data['message']))
                      <p class="text-sm text-base-content/80 mt-1">
                        {{ \Illuminate\Support\Str::limit($notification->data['message'], 200, ' ( More detail ) ') }}
                      </p>
                    @endif

                    {{-- Action Button jika ada link --}}
                    @if (isset($notification->data['action_url']))
                      <div class="mt-3">
                        <a href="{{ url($notification->data['action_url']) . '?notif_id=' . $notification->id }}"
                          class="btn btn-xs btn-outline btn-primary">
                          View Details
                        </a>
                      </div>
                    @endif
                  </div>

                </a>
              @endforeach
            @else
              <div class="flex flex-col items-center justify-center gap-4 p-12 text-center">
                <div class="opacity-20 w-32">
                  {!! file_get_contents(public_path('images/not-found.svg')) !!}
                </div>
                <div>
                  <h1 class="text-xl font-bold">Your inbox is empty</h1>
                  <p class="text-base-content/60">We'll notify you when something important happens.</p>
                </div>
              </div>
            @endif
          </div>
        </div>

        <div class="mt-4">
          {{-- {{ $notifications->links() }} Pagination --}}
        </div>
      </div>
    </div>
  </main>
@endsection
