@extends('layouts.auth')

@section('title', 'Forgot Password | HireDesk Laravel')
@section('body_class', 'login-page')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('login') }}"><b>HireDesk</b> Laravel</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                Enter your email address and we will send you a password reset link.
            </p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
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

                <button type="submit" class="btn btn-primary btn-block">
                    Send Password Reset Link
                </button>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}">Back to login</a>
            </p>
        </div>
    </div>
</div>
@endsection