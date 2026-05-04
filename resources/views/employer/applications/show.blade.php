@extends('layouts.admin')

@section('title', 'Review Application | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>Review Application</h1>
            <p class="text-muted mb-0">
                {{ $application->applicant->name }} applied for {{ $application->jobPost->title }}
            </p>
        </div>

        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.applications.index') }}">Applications</a>
                </li>
                <li class="breadcrumb-item active">Review</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $application->applicant->name }}</h3>

                    <div class="card-tools">
                        <span class="badge badge-{{ $application->statusBadgeClass() }}">
                            {{ $application->statusLabel() }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Email:</strong> {{ $application->applicant->email }}</p>
                    <p><strong>Job:</strong> {{ $application->jobPost->title }}</p>
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
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Update Status</h3>
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
                        <button type="submit" class="btn btn-primary btn-block">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            @if ($application->applicant?->applicantProfile)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Applicant Profile</h3>
                    </div>

                    <div class="card-body">
                        <p><strong>Headline:</strong> {{ $application->applicant->applicantProfile->headline ?? 'Not set' }}</p>
                        <p><strong>Experience:</strong> {{ $application->applicant->applicantProfile->experience_level ?? 'Not set' }}</p>
                        <p><strong>Skills:</strong> {{ $application->applicant->applicantProfile->skills ?? 'Not set' }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection