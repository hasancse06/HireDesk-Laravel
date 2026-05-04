@extends('layouts.admin')

@section('title', 'Application Details | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Application Details</h1>
            <p class="text-muted mb-0">{{ $application->jobPost->title }}</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('applicant.applications.index') }}">Applications</a>
                </li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    @if ($application->status === 'selected')
        <div class="alert alert-success">
            <h5>
                <i class="fas fa-user-check mr-1"></i>
                Congratulations!
            </h5>

            You have been selected for the
            <strong>{{ $application->jobPost->title }}</strong>
            position at
            <strong>{{ $application->jobPost->company_name }}</strong>.
        </div>
    @elseif ($application->status === 'rejected')
        <div class="alert alert-secondary">
            <h5>
                <i class="fas fa-info-circle mr-1"></i>
                Application Update
            </h5>

            Your application for
            <strong>{{ $application->jobPost->title }}</strong>
            was not selected this time.
        </div>
    @elseif ($application->status === 'shortlisted')
        <div class="alert alert-info">
            <h5>
                <i class="fas fa-star mr-1"></i>
                Shortlisted
            </h5>

            Your application has been shortlisted for the
            <strong>{{ $application->jobPost->title }}</strong>
            position.
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                {{ $application->jobPost->title }}
            </h3>

            <div class="card-tools">
                <span class="badge badge-{{ $application->statusBadgeClass() }} p-2">
                    {{ $application->statusLabel() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <strong>Company:</strong><br>
                        {{ $application->jobPost->company_name }}
                    </p>

                    <p>
                        <strong>Application Date:</strong><br>
                        {{ $application->created_at->format('M d, Y') }}
                    </p>

                    <p>
                        <strong>Expected Salary:</strong><br>
                        {{ $application->expected_salary ?? 'Not provided' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <p>
                        <strong>Status:</strong><br>
                        <span class="badge badge-{{ $application->statusBadgeClass() }}">
                            {{ $application->statusLabel() }}
                        </span>
                    </p>

                    <p>
                        <strong>Reviewed Date:</strong><br>
                        {{ $application->reviewed_at?->format('M d, Y') ?? 'Not reviewed yet' }}
                    </p>

                    <p>
                        <strong>Availability Date:</strong><br>
                        {{ $application->availability_date?->format('M d, Y') ?? 'Not provided' }}
                    </p>
                </div>
            </div>

            @if ($application->portfolio_url)
                <p>
                    <strong>Portfolio:</strong>
                    <a href="{{ $application->portfolio_url }}" target="_blank" rel="noopener">
                        {{ $application->portfolio_url }}
                    </a>
                </p>
            @endif

            @if ($application->resumeUrl())
                <p>
                    <strong>Resume:</strong>
                    <a href="{{ $application->resumeUrl() }}" target="_blank" rel="noopener">
                        View Resume
                    </a>
                </p>
            @endif

            <hr>

            <h5>Cover Letter</h5>

            <div>
                {!! nl2br(e($application->cover_letter)) !!}
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('applicant.applications.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Applications
            </a>

            <a href="{{ route('jobs.show', $application->jobPost) }}" class="btn btn-primary">
                <i class="fas fa-briefcase mr-1"></i>
                View Job
            </a>
        </div>
    </div>
@endsection