@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>User Change Requests</h2>
        <a class="btn btn-secondary" href="{{ route('home') }}">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    {{-- PENDING REQUESTS --}}
    <div class="card mb-4">
        <div class="card-header"><h4 class="mb-0">Pending Approval</h4></div>
        <div class="card-body">
            @forelse($pendingRequests as $request)
                <div class="row border-bottom py-3">
                    <div class="col-md-3">
                        <strong>User:</strong> {{ $request->user->name }} {{ $request->user->surname }}<br>
                        <small class="text-muted">{{ $request->user->email }}</small>
                    </div>
                    <div class="col-md-4">
                        <strong>Current Info</strong>
                        <ul>
                        @foreach($request->requested_data as $field => $newValue)
                            <li><strong>{{ Str::title(str_replace('_', ' ', $field)) }}:</strong> {{ $request->user->{$field} }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <strong>Requested Info</strong>
                        <ul>
                        @foreach($request->requested_data as $field => $newValue)
                             <li><strong>{{ Str::title(str_replace('_', ' ', $field)) }}:</strong> {{ $newValue }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <form action="{{ route('admin.requests.approve', $request) }}" method="POST" class="me-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                        </form>
                        <form action="{{ route('admin.requests.reject', $request) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>There are no pending change requests.</p>
            @endforelse
        </div>
    </div>

    {{-- HISTORICAL REQUESTS --}}
    <div class="card">
        <div class="card-header"><h4 class="mb-0">Request History</h4></div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Status</th>
                        <th>Reviewed By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historicalRequests as $request)
                    <tr>
                        <td>{{ $request->user->name }}</td>
                        <td>
                            @if($request->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>{{ $request->reviewer->name ?? 'N/A' }}</td>
                        <td>{{ $request->reviewed_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $historicalRequests->links() !!}
        </div>
    </div>
</div>
@endsection