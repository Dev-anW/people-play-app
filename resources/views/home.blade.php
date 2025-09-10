@extends('layouts.app')

@section('content')
<div class="container">

    @if(auth()->user()->is_admin)

        {{-- ========================================================== --}}
        {{-- ADMINS ONLY: TWO-COLUMN LAYOUT                           --}}
        {{-- ========================================================== --}}
        <div class="row">

            {{-- LEFT COLUMN --}}
            <div class="col-md-6">
                {{-- Main Dashboard Card --}}
                <div class="card mb-4">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        Welcome, {{ auth()->user()->name }}!

                        <div class="mt-3 p-3 border rounded">
                            <h4>Admin Tools</h4>
                            <p class="mb-2">Manage all registered users in the system.</p>
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Go to User Management</a>
                        </div>
                    </div>
                </div>

                {{-- Admin Guide Card --}}
                <div class="card">
                    <div class="card-header">
                        Admin Guide
                    </div>
                    <div class="card-body">
                        <p class="card-text">Understanding the parameters and scope of this application, a simple how to guide.</p>
                        <a href="{{ route('admin.guide') }}" class="btn btn-secondary">Read The Guide</a>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="col-md-6">
                {{-- Admin Account Details Card --}}
                <div class="card mb-4">
                    <div class="card-header">Admin Account Details</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }} {{ auth()->user()->surname }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
                            <li class="list-group-item"><strong>SA ID Number:</strong> {{ auth()->user()->sa_id_number }}</li>
                            <li class="list-group-item"><strong>Mobile:</strong> {{ auth()->user()->mobile_number ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Birth Date:</strong> {{ auth()->user()->birth_date ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Language:</strong> {{ auth()->user()->language }}</li>
                            <li class="list-group-item">
                                <strong>Interests:</strong>
                                @forelse(auth()->user()->interests as $interest)
                                    <span class="badge bg-secondary">{{ $interest->name }}</span>
                                @empty
                                    N/A
                                @endforelse
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                <div class="card-header">User Detail Changes</div>
                <div class="card-body text-center">
                    @inject('pendingCount', 'App\Models\UserChangeRequest')
                    @php
                        $count = $pendingCount->where('status', 'pending')->count();
                    @endphp

                    <h1 class="display-4 {{ $count > 0 ? 'text-warning' : 'text-success' }}">{{ $count }}</h1>
                    <p class="lead">Pending Change Requests</p>
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-primary">Review Requests</a>
                </div>
            </div>
            </div>
        </div>

    @else

        {{-- ========================================================== --}}
        {{-- NON-ADMINS ONLY: SINGLE-COLUMN LAYOUT                    --}}
        {{-- ========================================================== --}}
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        Welcome, {{ auth()->user()->name }}!

                        <div class="mt-4 p-4 border rounded">
                            <h4>My Profile</h4>
                            <p>Below are your current details on record. You can edit them at any time.</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ auth()->user()->name }} {{ auth()->user()->surname }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ auth()->user()->email }}</li>
                                <li class="list-group-item"><strong>SA ID Number:</strong> {{ auth()->user()->sa_id_number }}</li>
                                <li class="list-group-item"><strong>Account Verified:</strong> {{ auth()->user()->email_verified_at ? 'Yes' : 'No' }}</li>
                            </ul>
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit My Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
@endsection
