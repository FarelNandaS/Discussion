@extends('layout.default')
@section('title', 'Admin Dashboard')
@section('main')
    <div class="min-h-[calc(100vh-60px)] min-w-full p-4">
        <div class="grid grid-cols-3 gap-4">
            <div class="card bg-base-100 border border-gray-500">
                <div class="card-body p-0">
                    <div class="stat">
                        <div class="stat-figure">
                            <x-heroicon-o-user-group style="width: 70px;"/>
                        </div>
                        <div class="stat-title">
                            Total Users
                        </div>
                        <div class="stat-value">
                            {{ \App\Models\User::get()->count() }}
                        </div>
                        <div class="stat-desc">
                            1 more than last month
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 border border-gray-500">
                <div class="card-body p-0">
                    <div class="stat">
                        <div class="stat-title">
                            Reports not review
                        </div>
                        <div class="stat-value">
                            {{ $reportsCount }}
                        </div>
                        <div class="stat-desc">
                            10% more than last month
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 border border-gray-500">
                <div class="card-body p-0">
                    <div class="stat">
                        <div class="stat-title">
                            ini title
                        </div>
                        <div class="stat-value">
                            50%
                        </div>
                        <div class="stat-desc">
                            10% more than last month
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection