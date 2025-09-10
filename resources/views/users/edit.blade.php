@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                 <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit User: {{ $user->name }}</h4>
                    {{-- Navigation button --}}
                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back to User List</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('users._form')
                        <div class="text-center mt-4">
                             <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection