@extends('layouts.admin')

@section('title', 'Users | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User Management</h1>
            <p class="text-muted mb-0">Manage platform users and assigned roles.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-users mr-1"></i>
                Users
            </h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>
                            @forelse ($user->roles as $role)
                                <span class="badge badge-primary">
                                    {{ str_replace('_', ' ', $role->name) }}
                                </span>
                            @empty
                                <span class="badge badge-secondary">
                                    {{ str_replace('_', ' ', $user->role ?? 'No role') }}
                                </span>
                            @endforelse
                        </td>

                        <td>{{ $user->created_at?->format('M d, Y') }}</td>

                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>

                            @if (auth()->id() !== $user->id)
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No users found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection