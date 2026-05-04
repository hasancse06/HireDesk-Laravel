@extends('layouts.admin')

@section('title', 'Create Permission | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create Permission</h1>
            <p class="text-muted mb-0">Add a new application permission.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.permissions.index') }}">Permissions</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('admin.permissions.store') }}">
            @csrf

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-plus-circle mr-1"></i>
                    New Permission
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Permission Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Example: manage_reports"
                           required>

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted">
                        Spaces will be converted to underscores automatically.
                    </small>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Create Permission
                </button>

                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection