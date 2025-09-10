@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- LEFT COLUMN: THE EDIT FORM --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Request Profile Changes</h4>
                    <a class="btn btn-secondary" href="{{ route('home') }}">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    <p class="text-muted">You can update your interests immediately. All other changes require admin approval.</p>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        
                        @include('users._form', ['isRequest' => true])

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Submit Change Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIGHT COLUMN: CHANGE REQUEST HISTORY --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h4 class="mb-0">Your Change History</h4></div>
                <div class="card-body">
                    @forelse(auth()->user()->changeRequests as $request)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between">
                                <strong>Request on {{ $request->created_at->format('d M Y') }}</strong>
                                @if($request->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($request->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($request->status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </div>
                            <ul>
                                @foreach($request->requested_data as $field => $value)
                                    <li><strong>{{ Str::title(str_replace('_', ' ', $field)) }}:</strong> {{ $value }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p>You have no pending or past change requests.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
