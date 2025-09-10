@extends('layouts.app')

{{-- Push page-specific styles to the 'styles' stack in the layout --}}
@push('styles')
<style>
    /* This new wrapper will handle the vertical centering */
    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        /* Calculate the height of the viewport minus the navbar height (approx 56px) */
        min-height: calc(100vh - 56px);
    }

    /* Target the card header ONLY on this page */
    .login-card .card-header {
        background-color: #294858 !important; /* Your dark blue primary brand color */
        color: white !important;
    }

    .login-card .card-body {
    padding: 5rem; /* You can adjust this value (e.g., 2.5rem, 4rem) to get the exact height you like */
}
</style>
@endpush


@section('content')
{{-- Wrap the original container in our new flexbox wrapper --}}
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                {{-- Add the 'login-card' class for more specific targeting --}}
                <div class="card login-card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- NOTE: Structure changed to stack label on top of input -->
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email Address') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- NOTE: Structure changed for password field as well -->
    <div class="mb-4">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <!-- NOTE: Structure simplified for checkbox and button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
        </button>
    </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection