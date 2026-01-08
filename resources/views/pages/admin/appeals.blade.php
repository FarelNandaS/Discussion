@extends('layout.default')
@section('title', 'Admin appeals')
@section('script')
    @vite(['resources/js/admin/appeals.js'])
@endsection
@section('main')
  <main class="min-h-[calc(100vh-60px)] min-w-full p-4">
    <div class="flex flex-wrap w-full gap-2">
      <div class="w-full mb-4">
        <h3 class="text-2xl font-bold">Appeals</h3>
      </div>
      <div class="w-full">
        <div class="card bg-base-100 border border-gray-500">
          <div class="card-body">
            <table id="appealsTable" class="w-full dt-center hover stripe cell-border">
              <thead>
                <tr class="bg-primary text-white">
                  <th class="text-center">No</th>
                  <th class="text-center">Reported Username</th>
                  <th class="text-center">Reported Content</th>
                  <th class="text-center">Total Weight</th>
                  <th class="text-center">Total Reports</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center"></td>
                  <td class="text-center">dawda</td>
                  <td class="text-center">wdadwada</td>
                  <td class="text-end">dwadawda</td>
                  <td class="text-end">dwadawda</td>
                  <td class="text-center">
                    <a href="">
                        button dong
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
