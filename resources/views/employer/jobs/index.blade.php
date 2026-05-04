@extends('layouts.admin')

@section('title', 'My Jobs | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>My Jobs</h1>
            <p class="text-muted mb-0">Create, manage, publish, and close your job posts.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">My Jobs</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-briefcase mr-1"></i>
                Job Posts
            </h3>

            <div class="card-tools">
                <a href="{{ route('employer.jobs.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus mr-1"></i>
                    Post a Job
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Workplace</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Applications</th>
                    <th>Deadline</th>
                    <th style="width: 260px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($jobs as $job)
                    <tr>
                        <td>
                            <strong>{{ $job->title }}</strong>
                            <br>
                            <small class="text-muted">{{ $job->company_name }}</small>
                        </td>

                        <td>{{ $job->location ?? 'Remote' }}</td>

                        <td>
                            <span class="badge badge-info">
                                {{ $job->workplaceTypeLabel() }}
                            </span>
                        </td>

                        <td>{{ $job->jobTypeLabel() }}</td>

                        <td>
                            <span class="badge badge-{{ $job->statusBadgeClass() }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('employer.jobs.applications', $job) }}"
                            class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-users mr-1"></i>
                                {{ $job->applicationsCount() }}
                            </a>
                        </td>

                        <td>{{ $job->deadlineLabel() }}</td>

                        <td>
                            <a href="{{ route('jobs.show', $job) }}"
                               class="btn btn-sm btn-secondary"
                               target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('employer.jobs.edit', $job) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-edit"></i>
                            </a>

                            @if (! $job->isPublished())
                                <form method="POST"
                                      action="{{ route('employer.jobs.publish', $job) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            @else
                                <form method="POST"
                                      action="{{ route('employer.jobs.unpublish', $job) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                            @endif

                            @if (! $job->isClosed())
                                <form method="POST"
                                      action="{{ route('employer.jobs.close', $job) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="btn btn-sm btn-dark">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                </form>
                            @endif

                            <form method="POST"
                                  action="{{ route('employer.jobs.destroy', $job) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No job posts found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($jobs->hasPages())
            <div class="card-footer">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
@endsection