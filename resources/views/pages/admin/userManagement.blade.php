@extends('layout.default')
@section('title', 'Admin User Management')
@section('script')
  @vite(['resources/js/admin/userManagement.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">User Management</h3>
      </div>
      <div class="w-full">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <table id="appealsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Username</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Trust Score</th>
                  <th class="text-center">Role</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr class="row" data-id="{{ $user->id }}">
                    <td class="text-center"></td>
                    <td class="text-center">{{ $user->username }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">{{ $user->detail->trust_score ?? 0 }}</td>
                    <td class="text-center col-role">{{ $user->roles->count() > 0 ? $user->roles->pluck('name')->implode(', ') : '-' }}</td>
                    <td class="text-center flex col-action">
                      <a href="{{ route('admin-profile', ['username'=>$user->username]) }}" class="btn btn-primary btn-sm m-2">
                        {{-- <x-tabler-eye class="w-4 h-4"/> --}}
                        detail
                      </a>
                      @if ($user->hasRole('Admin'))
                        <button class="btn btn-primary btn-sm m-2" id="btnGiveRole"
                          onclick="ActionRole(this, {{ $user->id }}, 'remove')">Remove Admin</button>
                      @else
                        <button class="btn btn-primary btn-sm m-2" id="btnGiveRole"
                          onclick="ActionRole(this, {{ $user->id }}, 'add')">Give Admin</button>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    function ActionRole(btn, id, type) {
      const row = $(btn).closest('tr');

      showAlert('success', 'Processing...')

      $.ajax({
        url: "{{ route('ajax-manage-user-role') }}",
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
          id: id,
          type: type
        },
        success: function(res) {
          if (res.code == 200) {
            showAlert('success', 'Role updated successfully');

            row.find('.col-role').text(res.data);

            if (type === 'add') {
              row.find('#btnGiveRole').text('Remove Admin');
              row.find('#btnGiveRole').attr('onclick', `ActionRole(this, ${id}, 'remove')`);
            } else {
              row.find('#btnGiveRole').text('Give Admin');
              row.find('#btnGiveRole').attr('onclick', `ActionRole(this, ${id}, 'add')`);
            }
          } else {
            showAlert('error', res.data);
            console.error(res.data);
          }
        }
      })
    }
  </script>
@endsection
