@extends('layouts.admin')

@section('title', 'My Applications | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>My Applications</h1>
            <p class="text-muted mb-0">Track your submitted job applications.</p>
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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-alt mr-1"></i>
                Applications
            </h3>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th style="width: 140px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->jobPost->title }}</strong>
                        </td>

                        <td>{{ $application->jobPost->company_name }}</td>

                        <td>
                            <span class="badge badge-{{ $application->statusBadgeClass() }}">
                                {{ $application->statusLabel() }}
                            </span>
                        </td>

                        <td>{{ $application->created_at->format('M d, Y') }}</td>

                        <td>
                            <a href="{{ route('applicant.applications.show', $application) }}"
                               class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
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