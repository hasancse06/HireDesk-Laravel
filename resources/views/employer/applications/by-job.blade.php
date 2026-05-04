@extends('layouts.admin')

@section('title', 'Job Applications | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>Applications for Job</h1>
            <p class="text-muted mb-0">{{ $job->title }}</p>
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
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Status</th>
                    <th>Expected Salary</th>
                    <th>Applied</th>
                    <th style="width: 140px;">Actions</th>
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
                            <span class="badge badge-{{ $application->statusBadgeClass() }}">
                                {{ $application->statusLabel() }}
                            </span>
                        </td>

                        <td>{{ $application->expected_salary ?? 'Not provided' }}</td>

                        <td>{{ $application->created_at->format('M d, Y') }}</td>

                        <td>
                            <a href="{{ route('employer.applications.show', $application) }}"
                               class="btn btn-sm btn-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
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