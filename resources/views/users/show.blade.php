@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Show User Details</h2>
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong> {{ $user->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Surname:</strong> {{ $user->surname }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong> {{ $user->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Mobile Number:</strong> {{ $user->mobile_number ?? 'N/A' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>SA ID Number:</strong> {{ $user->sa_id_number }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Birth Date:</strong> {{ $user->birth_date ?? 'N/A' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Language:</strong> {{ $user->language }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Interests:</strong>
                @if($user->interests->count() > 0)
                    @foreach($user->interests as $interest)
                        <span class="badge bg-secondary">{{ $interest->name }}</span>
                    @endforeach
                @else
                    N/A
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email Verified:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y, H:i') : 'No' }}
            </div>
        </div>
    </div>
</div>
@endsection