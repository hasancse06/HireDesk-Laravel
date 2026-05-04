@extends('layouts.public')

@section('title', $job->title . ' at ' . $job->company_name . ' | HireDesk Laravel')
@section('meta_description', str($job->description)->limit(150))

@section('content')
    <section class="job-details-hero">
        <div class="public-container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="public-hero-kicker">
                        <i class="fas fa-briefcase"></i>
                        {{ $job->workplaceTypeLabel() }} {{ $job->jobTypeLabel() }}
                    </div>

                    <h1>{{ $job->title }}</h1>

                    <p class="mb-0">
                        <i class="fas fa-building mr-1"></i>
                        {{ $job->company_name }}

                        <span class="mx-2">•</span>

                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $job->location ?? 'Remote' }}
                    </p>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0 text-lg-right">
                    @auth
                        @role('applicant')
                            @if ($job->hasApplied(auth()->user()))
                                <a href="{{ route('applicant.applications.index') }}" class="public-btn public-btn-light w-100 justify-content-center">
                                    <i class="fas fa-check-circle"></i>
                                    Already Applied
                                </a>
                            @else
                                <a href="{{ route('applicant.jobs.apply.create', $job) }}" class="public-btn public-btn-primary w-100 justify-content-center">
                                    <i class="fas fa-paper-plane"></i>
                                    Apply Now
                                </a>
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}" class="public-btn public-btn-light">
                                Go to Dashboard
                            </a>
                        @endrole
                    @else
                        <a href="{{ route('login') }}" class="public-btn public-btn-primary">
                            <i class="fas fa-sign-in-alt"></i>
                            Login to Apply
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <section class="public-section">
        <div class="public-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="job-details-card mb-4">
                        <div class="mb-4">
                            <span class="hd-badge hd-badge-remote">
                                <i class="fas fa-laptop-house"></i>
                                {{ $job->workplaceTypeLabel() }}
                            </span>

                            <span class="hd-badge hd-badge-type">
                                <i class="fas fa-clock"></i>
                                {{ $job->jobTypeLabel() }}
                            </span>

                            <span class="hd-badge hd-badge-salary">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ $job->salaryRange() }}
                            </span>

                            <span class="hd-badge hd-badge-deadline">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $job->deadlineLabel() }}
                            </span>
                        </div>

                        <h2>Job Description</h2>

                        <div class="mt-3 mb-4">
                            {!! nl2br(e($job->description)) !!}
                        </div>

                        @if ($job->skills_required)
                            <hr>

                            <h3>Skills Required</h3>

                            <p class="job-skills">
                                {{ $job->skills_required }}
                            </p>
                        @endif
                    </div>

                    @if ($relatedJobs->isNotEmpty())
                        <div class="job-details-card">
                            <h3 class="mb-3">Related Jobs</h3>

                            @foreach ($relatedJobs as $relatedJob)
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                    <div>
                                        <strong>
                                            <a href="{{ route('jobs.show', $relatedJob) }}">
                                                {{ $relatedJob->title }}
                                            </a>
                                        </strong>

                                        <div class="text-muted small">
                                            {{ $relatedJob->company_name }} · {{ $relatedJob->workplaceTypeLabel() }}
                                        </div>
                                    </div>

                                    <a href="{{ route('jobs.show', $relatedJob) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="job-details-card job-summary-card mb-4">
                        <h3 class="mb-3">Job Summary</h3>

                        <p>
                            <strong><i class="fas fa-building mr-1"></i> Company</strong><br>
                            <a href="{{ route('companies.show', str($job->company_name)->slug()) }}">
                                {{ $job->company_name }}
                            </a>
                        </p>

                        <p>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong><br>
                            {{ $job->location ?? 'Remote' }}
                        </p>

                        <p>
                            <strong><i class="fas fa-laptop-house mr-1"></i> Workplace</strong><br>
                            {{ $job->workplaceTypeLabel() }}
                        </p>

                        <p>
                            <strong><i class="fas fa-clock mr-1"></i> Job Type</strong><br>
                            {{ $job->jobTypeLabel() }}
                        </p>

                        <p>
                            <strong><i class="fas fa-money-bill-wave mr-1"></i> Salary</strong><br>
                            {{ $job->salaryRange() }}
                        </p>

                        <p>
                            <strong><i class="fas fa-calendar-alt mr-1"></i> Deadline</strong><br>
                            {{ $job->deadlineLabel() }}
                        </p>

                        <hr>

                        @auth
                            @role('applicant')
                               @if ($job->hasApplied(auth()->user()))
                                    <a href="{{ route('applicant.applications.index') }}" class="public-btn public-btn-light">
                                        <i class="fas fa-check-circle"></i>
                                        Already Applied
                                    </a>
                                @else
                                    <a href="{{ route('applicant.jobs.apply.create', $job) }}" class="public-btn public-btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                        Apply Now
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('dashboard') }}" class="public-btn public-btn-primary w-100 justify-content-center">
                                    Go to Dashboard
                                </a>
                            @endrole
                        @else
                            <a href="{{ route('login') }}" class="public-btn public-btn-primary w-100 justify-content-center">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to Apply
                            </a>
                        @endauth

                        <small class="text-muted d-block mt-3 text-center">
                            Application workflow will be added in Phase 7.
                        </small>
                    </div>

                    @if ($job->employer?->employerProfile)
                        <div class="job-details-card">
                            <h3>About Company</h3>

                            <p class="mb-1">
                                <strong>{{ $job->employer->employerProfile->company_name }}</strong>
                            </p>

                            <p class="text-muted">
                                {{ $job->employer->employerProfile->industry ?? 'Company' }}
                            </p>

                            @if ($job->employer->employerProfile->company_description)
                                <p>
                                    {{ $job->employer->employerProfile->company_description }}
                                </p>
                            @endif

                            <a href="{{ route('companies.show', str($job->company_name)->slug()) }}" class="btn btn-outline-primary btn-block">
                                View Company
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection