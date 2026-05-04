@extends('layouts.admin')

@section('title', 'Job Applications | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>Applications for Job</h1>
            <p class="text-muted mb-0">{{ $job->title }} — {{ $job->company_name }}</p>
        </div>

        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.jobs.index') }}">My Jobs</a>
                </li>
                <li class="breadcrumb-item active">Applications</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-briefcase mr-1"></i>
                {{ $job->title }}
            </h3>

            <div class="card-tools">
                <span class="badge badge-primary">
                    {{ $applications->total() }} applications
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <strong>{{ $job->workplaceTypeLabel() }}</strong>
                    <p class="text-muted mb-0">Workplace</p>
                </div>

                <div class="col-md-3">
                    <strong>{{ $job->jobTypeLabel() }}</strong>
                    <p class="text-muted mb-0">Job Type</p>
                </div>

                <div class="col-md-3">
                    <strong>{{ $job->salaryRange() }}</strong>
                    <p class="text-muted mb-0">Salary</p>
                </div>

                <div class="col-md-3">
                    <strong>{{ $job->deadlineLabel() }}</strong>
                    <p class="text-muted mb-0">Deadline</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Skills</th>
                    <th>Status</th>
                    <th>Expected Salary</th>
                    <th>Applied</th>
                    <th style="width: 170px;">Actions</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>
                            <strong>{{ $application->applicant->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $application->applicant->email }}</small>
                        </td>

                        <td>
                            {{ $application->applicant->applicantProfile->skills ?? 'Not provided' }}
                        </td>

                        <td>
                            <span class="badge badge-{{ $application->statusBadgeClass() }}">
                                {{ $application->statusLabel() }}
                            </span>
                        </td>

                        <td>{{ $application->expected_salary ?? 'Not provided' }}</td>

                        <td>{{ $application->created_at->format('M d, Y') }}</td>

                        <td>
                            <a href="{{ route('employer.applications.show', $application) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye mr-1"></i>
                                Applicant Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No applications for this job yet.
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