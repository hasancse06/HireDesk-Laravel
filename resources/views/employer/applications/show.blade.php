@extends('layouts.admin')

@section('title', 'Applicant Details | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>Applicant Details</h1>
            <p class="text-muted mb-0">
                {{ $application->applicant->name }} applied for {{ $application->jobPost->title }}
            </p>
        </div>

        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.jobs.index') }}">My Jobs</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.jobs.applications', $application->jobPost) }}">Applications</a>
                </li>
                <li class="breadcrumb-item active">Applicant Details</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-tie mr-1"></i>
                        Applicant Information
                    </h3>

                    <div class="card-tools">
                        <span class="badge badge-{{ $application->statusBadgeClass() }}">
                            {{ $application->statusLabel() }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="media align-items-center mb-4">
                        <div class="mr-3 rounded-circle bg-primary d-flex align-items-center justify-content-center"
                             style="width: 72px; height: 72px;">
                            <i class="fas fa-user fa-2x text-white"></i>
                        </div>

                        <div class="media-body">
                            <h4 class="mb-1">{{ $application->applicant->name }}</h4>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope mr-1"></i>
                                {{ $application->applicant->email }}
                            </p>

                            @if ($application->applicant?->applicantProfile?->headline)
                                <p class="mb-0">
                                    {{ $application->applicant->applicantProfile->headline }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <strong>Expected Salary</strong><br>
                                {{ $application->expected_salary ?? 'Not provided' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Availability Date</strong><br>
                                {{ $application->availability_date?->format('M d, Y') ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    @if ($application->applicant?->applicantProfile)
                        <hr>

                        <h5>Professional Profile</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <strong>Experience Level</strong><br>
                                    {{ $application->applicant->applicantProfile->experience_level ?? 'Not set' }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p>
                                    <strong>Location</strong><br>
                                    {{ $application->applicant->applicantProfile->location ?? 'Not set' }}
                                </p>
                            </div>
                        </div>

                        <p>
                            <strong>Skills</strong><br>
                            {{ $application->applicant->applicantProfile->skills ?? 'Not provided' }}
                        </p>

                        @if ($application->applicant->applicantProfile->bio)
                            <p>
                                <strong>Bio</strong><br>
                                {{ $application->applicant->applicantProfile->bio }}
                            </p>
                        @endif
                    @endif

                    <hr>

                    <h5>Links</h5>

                    <div class="d-flex flex-wrap gap-2">
                        @if ($application->resumeUrl())
                            <a href="{{ $application->resumeUrl() }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                <i class="fas fa-file-download mr-1"></i>
                                Resume
                            </a>
                        @endif

                        @if ($application->portfolio_url)
                            <a href="{{ $application->portfolio_url }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-outline-info btn-sm mr-2 mb-2">
                                <i class="fas fa-globe mr-1"></i>
                                Portfolio
                            </a>
                        @endif

                        @if ($application->applicant?->applicantProfile?->portfolio_url && $application->applicant->applicantProfile->portfolio_url !== $application->portfolio_url)
                            <a href="{{ $application->applicant->applicantProfile->portfolio_url }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-outline-info btn-sm mr-2 mb-2">
                                <i class="fas fa-briefcase mr-1"></i>
                                Profile Portfolio
                            </a>
                        @endif

                        @if ($application->applicant?->applicantProfile?->github_url)
                            <a href="{{ $application->applicant->applicantProfile->github_url }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-outline-dark btn-sm mr-2 mb-2">
                                <i class="fab fa-github mr-1"></i>
                                GitHub
                            </a>
                        @endif

                        @if ($application->applicant?->applicantProfile?->linkedin_url)
                            <a href="{{ $application->applicant->applicantProfile->linkedin_url }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-outline-primary btn-sm mr-2 mb-2">
                                <i class="fab fa-linkedin mr-1"></i>
                                LinkedIn
                            </a>
                        @endif
                    </div>

                    @if (! $application->resumeUrl() && ! $application->portfolio_url && ! $application->applicant?->applicantProfile?->github_url && ! $application->applicant?->applicantProfile?->linkedin_url)
                        <p class="text-muted mb-0">No resume or portfolio links provided.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope-open-text mr-1"></i>
                        Cover Letter
                    </h3>
                </div>

                <div class="card-body">
                    {!! nl2br(e($application->cover_letter)) !!}
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks mr-1"></i>
                        Application Status
                    </h3>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Current Status</strong><br>
                        <span class="badge badge-{{ $application->statusBadgeClass() }} p-2">
                            {{ $application->statusLabel() }}
                        </span>
                    </p>

                    <p>
                        <strong>Applied At</strong><br>
                        {{ $application->created_at->format('M d, Y H:i') }}
                    </p>

                    <p>
                        <strong>Reviewed At</strong><br>
                        {{ $application->reviewed_at?->format('M d, Y H:i') ?? 'Not reviewed yet' }}
                    </p>
                </div>

                <div class="card-footer">
                    <form method="POST"
                          action="{{ route('employer.applications.shortlist', $application) }}"
                          class="mb-2">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-info btn-block"
                                {{ $application->status === 'shortlisted' ? 'disabled' : '' }}>
                            <i class="fas fa-star mr-1"></i>
                            Shortlist
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('employer.applications.select', $application) }}"
                          class="mb-2">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-success btn-block"
                                {{ $application->status === 'selected' ? 'disabled' : '' }}>
                            <i class="fas fa-user-check mr-1"></i>
                            Select Applicant
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('employer.applications.reject', $application) }}"
                          onsubmit="return confirm('Are you sure you want to reject this application?');">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="btn btn-danger btn-block"
                                {{ $application->status === 'rejected' ? 'disabled' : '' }}>
                            <i class="fas fa-user-times mr-1"></i>
                            Reject Application
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manual Status Update</h3>
                </div>

                <form method="POST" action="{{ route('employer.applications.status', $application) }}">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <div class="form-group">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                @foreach (['pending', 'shortlisted', 'selected', 'rejected'] as $status)
                                    <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary btn-block">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <div class="card card-dark">
                <div class="card-header">
                    <h3 class="card-title">Job Details</h3>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Job</strong><br>
                        {{ $application->jobPost->title }}
                    </p>

                    <p>
                        <strong>Company</strong><br>
                        {{ $application->jobPost->company_name }}
                    </p>

                    <p>
                        <strong>Type</strong><br>
                        {{ $application->jobPost->jobTypeLabel() }}
                    </p>

                    <p>
                        <strong>Workplace</strong><br>
                        {{ $application->jobPost->workplaceTypeLabel() }}
                    </p>

                    <a href="{{ route('jobs.show', $application->jobPost) }}"
                       target="_blank"
                       class="btn btn-outline-light btn-block">
                        View Public Job
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection