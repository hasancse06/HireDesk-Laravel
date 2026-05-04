@extends('layouts.admin')

@section('title', 'Permissions | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Permission Management</h1>
            <p class="text-muted mb-0">Create and manage application permissions.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Permissions</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-key mr-1"></i>
                Permissions
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Add Permission
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th>Created</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>

                        <td>
                            <span class="badge badge-dark">
                                {{ str_replace('_', ' ', $permission->name) }}
                            </span>
                        </td>

                        <td>{{ $permission->guard_name }}</td>

                        <td>{{ $permission->created_at?->format('M d, Y') }}</td>

                        <td>
                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.permissions.destroy', $permission) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No permissions found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($permissions->hasPages())
            <div class="card-footer">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>
@endsection