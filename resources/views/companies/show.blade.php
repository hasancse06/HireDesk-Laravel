@extends('layouts.public')

@section('title', $profile->company_name . ' Jobs | HireDesk Laravel')
@section('meta_description', 'View company profile and open jobs from ' . $profile->company_name . ' on HireDesk Laravel.')

@section('content')
    <section class="public-section">
        <div class="public-container">
            <div class="company-header">
                <div class="d-flex align-items-start flex-wrap">
                    <div class="company-logo-placeholder mr-3 mb-3">
                        {{ strtoupper(substr($profile->company_name, 0, 1)) }}
                    </div>

                    <div class="flex-grow-1">
                        <h1 class="font-weight-bold mb-2">
                            {{ $profile->company_name }}
                        </h1>

                        <p class="text-muted mb-2">
                            <i class="fas fa-industry mr-1"></i>
                            {{ $profile->industry ?? 'Company' }}

                            <span class="mx-2">•</span>

                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $profile->location ?? 'Location not set' }}

                            @if ($profile->remote_friendly)
                                <span class="mx-2">•</span>
                                <i class="fas fa-laptop-house mr-1"></i>
                                Remote Friendly
                            @endif
                        </p>

                        @if ($profile->company_website)
                            <a href="{{ $profile->company_website }}"
                               target="_blank"
                               rel="noopener"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-globe mr-1"></i>
                                Visit Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="company-profile-card">
                        <h3 class="font-weight-bold">Company Overview</h3>

                        <p class="text-muted mb-3">
                            {{ $profile->company_description ?? 'No company description has been added yet.' }}
                        </p>

                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <strong>Company Size:</strong>
                                {{ $profile->company_size ?? 'Not specified' }}
                            </li>

                            <li class="mb-2">
                                <strong>Industry:</strong>
                                {{ $profile->industry ?? 'Not specified' }}
                            </li>

                            <li class="mb-2">
                                <strong>Location:</strong>
                                {{ $profile->location ?? 'Not specified' }}
                            </li>

                            <li>
                                <strong>Remote Friendly:</strong>
                                {{ $profile->remote_friendly ? 'Yes' : 'No' }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="job-list-header mt-0">
                        <div>
                            <h2>Open Jobs</h2>
                            <p class="text-muted mb-0">
                                Current published job opportunities from {{ $profile->company_name }}.
                            </p>
                        </div>

                        <span class="badge badge-primary p-2">
                            {{ $jobs->total() }} jobs
                        </span>
                    </div>

                    @forelse ($jobs as $job)
                        <article class="job-card-public">
                            <div class="job-card-top">
                                <div class="company-logo-placeholder">
                                    {{ strtoupper(substr($job->company_name, 0, 1)) }}
                                </div>

                                <div class="flex-grow-1">
                                    <h3>
                                        <a href="{{ route('jobs.show', $job) }}">
                                            {{ $job->title }}
                                        </a>
                                    </h3>

                                    <div class="job-meta">
                                        <span>
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $job->location ?? 'Remote' }}
                                        </span>

                                        <span>
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            {{ $job->deadlineLabel() }}
                                        </span>
                                    </div>

                                    <div>
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
                                    </div>

                                    <div class="job-card-footer">
                                        <small class="text-muted">
                                            Posted {{ $job->published_at?->diffForHumans() ?? $job->created_at->diffForHumans() }}
                                        </small>

                                        <a href="{{ route('jobs.show', $job) }}" class="public-btn public-btn-primary">
                                            View Details
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="job-card-public text-center">
                            <h3>No open jobs</h3>
                            <p class="text-muted mb-0">
                                This company does not have any published jobs right now.
                            </p>
                        </div>
                    @endforelse

                    @if ($jobs->hasPages())
                        <div class="mt-4">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection