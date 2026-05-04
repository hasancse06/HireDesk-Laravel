@extends('layouts.admin')

@section('title', 'Roles | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Role Management</h1>
            <p class="text-muted mb-0">Create roles and assign permissions.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user-shield mr-1"></i>
                Roles
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Add Role
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Name</th>
                    <th>Users</th>
                    <th>Permissions</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>

                        <td>
                            <span class="badge badge-primary">
                                {{ str_replace('_', ' ', $role->name) }}
                            </span>
                        </td>

                        <td>{{ $role->users_count }}</td>

                        <td>
                            @forelse ($role->permissions as $permission)
                                <span class="badge badge-light border mb-1">
                                    {{ str_replace('_', ' ', $permission->name) }}
                                </span>
                            @empty
                                <span class="text-muted">No permissions</span>
                            @endforelse
                        </td>

                        <td>
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.roles.destroy', $role) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this role?');">
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
                            No roles found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($roles->hasPages())
            <div class="card-footer">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
@endsection