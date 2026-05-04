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
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $application->jobPost->title }}</h3>

            <div class="card-tools">
                <span class="badge badge-{{ $application->statusBadgeClass() }}">
                    {{ $application->statusLabel() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <p><strong>Company:</strong> {{ $application->jobPost->company_name }}</p>
            <p><strong>Expected Salary:</strong> {{ $application->expected_salary ?? 'Not provided' }}</p>
            <p><strong>Availability Date:</strong> {{ $application->availability_date?->format('M d, Y') ?? 'Not provided' }}</p>

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
                    <a href="{{ $application->resumeUrl() }}" target="_blank">
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
                Back to Applications
            </a>
        </div>
    </div>
@endsection