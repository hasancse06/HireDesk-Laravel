@extends('layouts.admin')

@section('title', 'Create Role | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Role</h1>
            <p class="text-muted mb-0">Add a new role and assign permissions.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.roles.index') }}">Roles</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle mr-1"></i>
                    New Role
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Role Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Example: content_manager"
                           required>

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted">
                        Spaces will be converted to underscores automatically.
                    </small>
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
                                           {{ in_array($permission->name, old('permissions', []), true) ? 'checked' : '' }}>

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
                    Create Role
                </button>

                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection