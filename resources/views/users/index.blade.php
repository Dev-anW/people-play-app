@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>User Management</h2>
                <div>
        <a class="btn btn-secondary me-2" href="{{ route('home') }}">Back to Dashboard</a>
        <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
    </div>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search and Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search by Name/Email</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="e.g., John Doe">
                </div>
                <div class="col-md-2">
                    <label for="interest_id" class="form-label">Interest</label>
                    <select id="interest_id" name="interest_id" class="form-select">
                        <option value="">All</option>
                        @foreach ($interests as $interest)
                            <option value="{{ $interest->id }}" {{ request('interest_id') == $interest->id ? 'selected' : '' }}>
                                {{ $interest->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                 <div class="col-md-2">
                    <label for="verified" class="form-label">Status</label>
                    <select id="verified" name="verified" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Verified</option>
                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Unverified</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-label">Sort By</label>
                    <select id="sort" name="sort" class="form-select">
                        <option value="">Default</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="age_desc" {{ request('sort') == 'age_desc' ? 'selected' : '' }}>Age (Oldest)</option>
                        <option value="age_asc" {{ request('sort') == 'age_asc' ? 'selected' : '' }}>Age (Youngest)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link w-100 mt-1">Clear</a>
                </div>
            </form>
        </div>
    </div>


    <table class="table table-bordered bg-white">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Verified</th>
            <th width="200px">Action</th>
        </tr>
        @forelse ($users as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }} {{ $user->surname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
            <td>
                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                    <a href="{{ route('users.show',$user->id) }}" style="color: #294858; text-decoration: none; font-weight: bold; margin-right: 15px;">View</a>
                    <a href="{{ route('users.edit',$user->id) }}" style="color: black; text-decoration: none; font-weight: bold; margin-right: 15px;">Edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: red; text-decoration: none; font-weight: bold; border: none; background: none; padding: 0; cursor: pointer;">Delete</button>
                </form>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No users found matching your criteria.</td>
            </tr>
        @endforelse
    </table>

    {!! $users->links() !!}
</div>
@endsection
