@extends('layouts.auth')

@section('title', 'Reset Password | HireDesk Laravel')
@section('body_class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>HireDesk</b> Laravel</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Create a new password for your account.</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', request('email')) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        required
                        autofocus
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    @error('email')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="New password"
                        required
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm new password"
                        required
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Reset Password
                </button>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </div>
    </div>
</div>
@endsection