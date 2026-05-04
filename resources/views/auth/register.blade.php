@extends('layouts.auth')

@section('title', 'Register | HireDesk Laravel')
@section('body_class', 'register-page')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ route('register') }}"><b>HireDesk</b> Laravel</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Create your HireDesk account</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Please fix the errors below and try again.
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Full name"
                        required
                        autofocus
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                    @error('name')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email"
                        required
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

                <div class="form-group">
                    <label>Register As</label>

                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Select account type</option>
                        <option value="applicant" {{ old('role') === 'applicant' ? 'selected' : '' }}>
                            Applicant
                        </option>
                        <option value="employer" {{ old('role') === 'employer' ? 'selected' : '' }}>
                            Employer
                        </option>
                    </select>

                    @error('role')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password"
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
                        placeholder="Retype password"
                        required
                    >

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Register
                </button>
            </form>

            <p class="mb-0 mt-3">
                <a href="{{ route('login') }}" class="text-center">
                    I already have an account
                </a>
            </p>
        </div>
    </div>
</div>
@endsection