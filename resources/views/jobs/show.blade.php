@extends('layouts.admin')

@section('title', $job->title . ' | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>{{ $job->title }}</h1>
            <p class="text-muted mb-0">
                {{ $job->company_name }} — {{ $job->location ?? 'Remote' }}
            </p>
        </div>

        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('jobs.index') }}">Jobs</a>
                </li>
                <li class="breadcrumb-item active">Details</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $job->title }}</h3>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge badge-info">
                            {{ $job->workplaceTypeLabel() }}
                        </span>

                        <span class="badge badge-primary">
                            {{ $job->jobTypeLabel() }}
                        </span>

                        <span class="badge badge-success">
                            {{ $job->salaryRange() }}
                        </span>
                    </div>

                    <h5>Job Description</h5>

                    <div class="mb-4">
                        {!! nl2br(e($job->description)) !!}
                    </div>

                    @if ($job->skills_required)
                        <h5>Skills Required</h5>

                        <p>{{ $job->skills_required }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-1"></i>
                        Job Summary
                    </h3>
                </div>

                <div class="card-body">
                    <strong>
                        <i class="fas fa-building mr-1"></i>
                        Company
                    </strong>

                    <p class="text-muted">
                        {{ $job->company_name }}
                    </p>

                    <hr>

                    <strong>
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Location
                    </strong>

                    <p class="text-muted">
                        {{ $job->location ?? 'Remote' }}
                    </p>

                    <hr>

                    <strong>
                        <i class="fas fa-laptop-house mr-1"></i>
                        Workplace
                    </strong>

                    <p class="text-muted">
                        {{ $job->workplaceTypeLabel() }}
                    </p>

                    <hr>

                    <strong>
                        <i class="fas fa-clock mr-1"></i>
                        Job Type
                    </strong>

                    <p class="text-muted">
                        {{ $job->jobTypeLabel() }}
                    </p>

                    <hr>

                    <strong>
                        <i class="fas fa-money-bill-wave mr-1"></i>
                        Salary
                    </strong>

                    <p class="text-muted">
                        {{ $job->salaryRange() }}
                    </p>

                    <hr>

                    <strong>
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Deadline
                    </strong>

                    <p class="text-muted">
                        {{ $job->deadlineLabel() }}
                    </p>

                    <a href="#" class="btn btn-primary btn-block disabled">
                        Apply Now
                    </a>

                    <small class="text-muted d-block mt-2 text-center">
                        Application workflow will be added in Phase 7.
                    </small>
                </div>
            </div>

            @if ($job->employer?->employerProfile)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">About Company</h3>
                    </div>

                    <div class="card-body">
                        <p class="mb-1">
                            <strong>{{ $job->employer->employerProfile->company_name }}</strong>
                        </p>

                        <p class="text-muted mb-2">
                            {{ $job->employer->employerProfile->industry ?? 'Company' }}
                        </p>

                        @if ($job->employer->employerProfile->company_description)
                            <p>
                                {{ $job->employer->employerProfile->company_description }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection