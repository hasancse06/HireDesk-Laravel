@extends('layouts.admin')

@section('title', 'Edit User | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit User</h1>
            <p class="text-muted mb-0">Update user details and assigned role.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users.index') }}">Users</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-edit mr-1"></i>
                    {{ $user->name }}
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required>

                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Role</label>

                    <select name="role"
                            class="form-control @error('role') is-invalid @enderror"
                            required>
                        <option value="">Select role</option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role', $user->primaryRoleName()) === $role->name ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', ucfirst($role->name)) }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Update User
                </button>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection