@extends('layouts.admin')

@section('title', 'Edit Permission | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Permission</h1>
            <p class="text-muted mb-0">Update permission details.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.permissions.index') }}">Permissions</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
            @csrf
            @method('PUT')

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-key mr-1"></i>
                    {{ str_replace('_', ' ', $permission->name) }}
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Permission Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $permission->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Update Permission
                </button>

                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection