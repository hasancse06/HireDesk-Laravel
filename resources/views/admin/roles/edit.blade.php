@extends('layouts.admin')

@section('title', 'Edit Role | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Role</h1>
            <p class="text-muted mb-0">Update role name and permissions.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.roles.index') }}">Roles</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-shield mr-1"></i>
                    {{ str_replace('_', ' ', $role->name) }}
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Role Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $role->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Permissions</label>

                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->name }}"
                                           id="permission_{{ $permission->id }}"
                                           class="custom-control-input"
                                           {{ in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray()), true) ? 'checked' : '' }}>

                                    <label for="permission_{{ $permission->id }}" class="custom-control-label">
                                        {{ str_replace('_', ' ', $permission->name) }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Update Role
                </button>

                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection