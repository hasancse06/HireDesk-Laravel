@extends('layouts.admin')

@section('title', 'Applications | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Applications</h1>
            <p class="text-muted mb-0">Review applications submitted to your jobs.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Applications</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <form method="GET" action="{{ route('employer.applications.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            @foreach (['pending', 'shortlisted', 'selected', 'rejected'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('employer.applications.index') }}" class="btn btn-secondary btn-block">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Job</th>
                    <th>Status</th>
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

                        <td>{{ $application->jobPost->title }}</td>

                        <td>
                            <span class="badge badge-{{ $application->statusBadgeClass() }}">
                                {{ $application->statusLabel() }}
                            </span>
                        </td>

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
                            No applications found.
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