@extends('layouts.admin')

@section('title', 'My Applications | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>My Applications</h1>
            <p class="text-muted mb-0">Track your submitted job applications and hiring status.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">My Applications</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $applications->total() }}</h3>
                    <p>Jobs Applied To</p>
                </div>

                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>

                <a href="{{ route('jobs.index') }}" class="small-box-footer">
                    Browse Jobs <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ auth()->user()->jobApplications()->where('status', 'pending')->count() }}</h3>
                    <p>Pending</p>
                </div>

                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>

                <a href="#" class="small-box-footer">
                    Awaiting Review
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ auth()->user()->jobApplications()->where('status', 'selected')->count() }}</h3>
                    <p>Selected</p>
                </div>

                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>

                <a href="#" class="small-box-footer">
                    Congratulations
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ auth()->user()->jobApplications()->where('status', 'rejected')->count() }}</h3>
                    <p>Rejected</p>
                </div>

                <div class="icon">
                    <i class="fas fa-user-times"></i>
                </div>

                <a href="#" class="small-box-footer">
                    Keep Applying
                </a>
            </div>
        </div>
    </div>

    @foreach (auth()->user()->unreadNotifications as $notification)
        <div class="alert alert-info alert-dismissible fade show">
            <i class="fas fa-bell mr-1"></i>
            {{ $notification->data['message'] ?? 'You have a new notification.' }}

            <form method="POST"
                action="{{ route('notifications.read', $notification->id) }}"
                class="d-inline ml-2">
                @csrf

                <button type="submit" class="btn btn-link p-0 align-baseline">
                    View
                </button>
            </form>

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endforeach

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-alt mr-1"></i>
                Application History
            </h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Application Date</th>
                    <th>Reviewed</th>
                    <th style="width: 140px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->jobPost->title }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $application->jobPost->jobTypeLabel() }} · {{ $application->jobPost->workplaceTypeLabel() }}
                            </small>
                        </td>

                        <td>{{ $application->jobPost->company_name }}</td>

                        <td>
                            <span class="badge badge-{{ $application->statusBadgeClass() }} p-2">
                                {{ $application->statusLabel() }}
                            </span>

                            @if ($application->status === 'selected')
                                <div class="small text-success mt-1">
                                    Congratulations!
                                </div>
                            @elseif ($application->status === 'rejected')
                                <div class="small text-muted mt-1">
                                    Not selected
                                </div>
                            @elseif ($application->status === 'shortlisted')
                                <div class="small text-info mt-1">
                                    Shortlisted
                                </div>
                            @endif
                        </td>

                        <td>{{ $application->created_at->format('M d, Y') }}</td>

                        <td>
                            {{ $application->reviewed_at?->format('M d, Y') ?? 'Not reviewed yet' }}
                        </td>

                        <td>
                            <a href="{{ route('applicant.applications.show', $application) }}"
                               class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            You have not applied to any jobs yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($applications->hasPages())
            <div class="card-footer">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
@endsection