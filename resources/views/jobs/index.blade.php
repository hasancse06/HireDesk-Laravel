@extends('layouts.admin')

@section('title', 'Browse Jobs | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Browse Jobs</h1>
            <p class="text-muted mb-0">Search and discover published job opportunities.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Jobs</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-search mr-1"></i>
                Search Jobs
            </h3>
        </div>

        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Search</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Job title, company, skill...">
                    </div>

                    <div class="col-md-3">
                        <label>Location</label>
                        <input type="text"
                               name="location"
                               value="{{ request('location') }}"
                               class="form-control"
                               placeholder="Remote, London, Dhaka...">
                    </div>

                    <div class="col-md-2">
                        <label>Workplace</label>
                        <select name="workplace_type" class="form-control">
                            <option value="">Any</option>
                            <option value="remote" {{ request('workplace_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                            <option value="on_site" {{ request('workplace_type') === 'on_site' ? 'selected' : '' }}>On-site</option>
                            <option value="hybrid" {{ request('workplace_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Job Type</label>
                        <select name="job_type" class="form-control">
                            <option value="">Any</option>
                            <option value="full_time" {{ request('job_type') === 'full_time' ? 'selected' : '' }}>Full-time</option>
                            <option value="part_time" {{ request('job_type') === 'part_time' ? 'selected' : '' }}>Part-time</option>
                            <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-secondary">
                    Reset Filters
                </a>
            </div>
        </form>
    </div>

    @forelse ($jobs as $job)
        <div class="card job-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h4 class="mb-1">
                            <a href="{{ route('jobs.show', $job) }}">
                                {{ $job->title }}
                            </a>
                        </h4>

                        <p class="text-muted mb-2">
                            <i class="fas fa-building mr-1"></i>
                            {{ $job->company_name }}

                            <span class="mx-2">•</span>

                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $job->location ?? 'Remote' }}
                        </p>

                        <div class="mb-2">
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

                        @if ($job->skills_required)
                            <p class="mb-2">
                                <strong>Skills:</strong>
                                {{ $job->skills_required }}
                            </p>
                        @endif

                        <p class="text-muted mb-0">
                            Deadline: {{ $job->deadlineLabel() }}
                        </p>
                    </div>

                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body text-center text-muted">
                No published jobs found.
            </div>
        </div>
    @endforelse

    @if ($jobs->hasPages())
        <div class="mt-3">
            {{ $jobs->links() }}
        </div>
    @endif
@endsection