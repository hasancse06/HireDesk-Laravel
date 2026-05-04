@extends('layouts.public')

@section('title', 'Browse Remote Jobs | HireDesk Laravel')
@section('meta_description', 'Browse remote, hybrid, and on-site jobs on HireDesk Laravel. Search by title, company, skill, location, and job type.')

@section('content')
    <section class="public-hero">
        <div class="public-container">
            <div class="public-hero-grid">
                <div>
                    <div class="public-hero-kicker">
                        <i class="fas fa-rocket"></i>
                        Open-source Laravel job board starter
                    </div>

                    <h1>Find your next opportunity with HireDesk.</h1>

                    <p>
                        Browse curated job opportunities from companies hiring Laravel developers,
                        backend engineers, frontend developers, and remote-ready professionals.
                    </p>

                    <div class="public-hero-actions">
                        <a href="#jobs" class="public-btn public-btn-primary">
                            <i class="fas fa-search"></i>
                            Browse Jobs
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="public-btn public-btn-light">
                                <i class="fas fa-tachometer-alt"></i>
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="public-btn public-btn-light">
                                <i class="fas fa-user-plus"></i>
                                Create Account
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="hero-stat-card">
                    <div class="hero-stat-item">
                        <span class="hero-stat-label">Published Jobs</span>
                        <span class="hero-stat-value">{{ $stats['published_jobs'] ?? 0 }}</span>
                    </div>

                    <div class="hero-stat-item">
                        <span class="hero-stat-label">Remote Jobs</span>
                        <span class="hero-stat-value">{{ $stats['remote_jobs'] ?? 0 }}</span>
                    </div>

                    <div class="hero-stat-item">
                        <span class="hero-stat-label">Hiring Companies</span>
                        <span class="hero-stat-value">{{ $stats['companies'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="public-section" id="jobs">
        <div class="public-container">
            <div class="search-panel">
                <form method="GET" action="{{ route('jobs.index') }}">
                    <div class="row">
                        <div class="col-lg-4 mb-3 mb-lg-0">
                            <label>Search keyword</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control form-control-lg"
                                   placeholder="Laravel, PHP, API, company...">
                        </div>

                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <label>Location</label>
                            <input type="text"
                                   name="location"
                                   value="{{ request('location') }}"
                                   class="form-control form-control-lg"
                                   placeholder="Remote, London, Dhaka...">
                        </div>

                        <div class="col-lg-2 mb-3 mb-lg-0">
                            <label>Workplace</label>
                            <select name="workplace_type" class="form-control form-control-lg">
                                <option value="">Any</option>
                                <option value="remote" {{ request('workplace_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="on_site" {{ request('workplace_type') === 'on_site' ? 'selected' : '' }}>On-site</option>
                                <option value="hybrid" {{ request('workplace_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>

                        <div class="col-lg-2 mb-3 mb-lg-0">
                            <label>Type</label>
                            <select name="job_type" class="form-control form-control-lg">
                                <option value="">Any</option>
                                <option value="full_time" {{ request('job_type') === 'full_time' ? 'selected' : '' }}>Full-time</option>
                                <option value="part_time" {{ request('job_type') === 'part_time' ? 'selected' : '' }}>Part-time</option>
                                <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                        </div>

                        <div class="col-lg-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'location', 'workplace_type', 'job_type']))
                        <div class="mt-3">
                            <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-light border">
                                <i class="fas fa-times mr-1"></i>
                                Clear filters
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="job-list-header">
                <div>
                    <h2>Latest Jobs</h2>
                    <p class="text-muted mb-0">
                        Showing published opportunities that are currently open.
                    </p>
                </div>

                <span class="badge badge-primary p-2">
                    {{ $jobs->total() }} jobs found
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
                                    <i class="fas fa-building mr-1"></i>
                                    <a href="{{ route('companies.show', str($job->company_name)->slug()) }}">
                                        {{ $job->company_name }}
                                    </a>
                                </span>

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

                            @if ($job->skills_required)
                                <p class="job-skills mb-0">
                                    <strong>Skills:</strong> {{ $job->skills_required }}
                                </p>
                            @endif

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
                    <h3>No jobs found</h3>
                    <p class="text-muted mb-3">
                        Try changing your search keyword, location, workplace type, or job type.
                    </p>

                    <a href="{{ route('jobs.index') }}" class="public-btn public-btn-primary">
                        Reset Search
                    </a>
                </div>
            @endforelse

            @if ($jobs->hasPages())
                <div class="mt-4">
                    {{ $jobs->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection