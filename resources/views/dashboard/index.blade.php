@extends('layouts.admin')

@section('title', 'Dashboard | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
            <p class="text-muted mb-0">
                Welcome back, {{ auth()->user()->name }}. You are viewing the
                <strong class="text-capitalize">{{ $dashboardType ?? 'default' }}</strong>
                dashboard as
                <strong class="text-capitalize">{{ str_replace('_', ' ', auth()->user()->primaryRoleName()) }}</strong>.
            </p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>0</h3>
                    <p>Total Jobs</p>
                </div>

                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>

                <a href="#" class="small-box-footer">
                    View Jobs <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>0</h3>
                    <p>Applications</p>
                </div>

                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>

                <a href="#" class="small-box-footer">
                    View Applications <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>0</h3>
                    <p>Employers</p>
                </div>

                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>

                <a href="#" class="small-box-footer">
                    View Employers <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>0</h3>
                    <p>Applicants</p>
                </div>

                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>

                <a href="#" class="small-box-footer">
                    View Applicants <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    @if (in_array($dashboardType ?? null, ['employer', 'applicant'], true))
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-id-card mr-1"></i>
                            Complete Your Profile
                        </h3>
                    </div>

                    <div class="card-body">
                        <p class="mb-2">
                            Your {{ $dashboardType }} profile is
                            <strong>{{ $profileCompletion ?? 0 }}%</strong>
                            complete.
                        </p>

                        <div class="progress mb-3">
                            <div class="progress-bar"
                                role="progressbar"
                                style="width: {{ $profileCompletion ?? 0 }}%;"
                                aria-valuenow="{{ $profileCompletion ?? 0 }}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                {{ $profileCompletion ?? 0 }}%
                            </div>
                        </div>

                        <a href="{{ $profileEditUrl ?? '#' }}" class="btn btn-primary">
                            <i class="fas fa-user-edit mr-1"></i>
                            Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">Recent Jobs</h3>

                    <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>Senior Laravel Developer</td>
                            <td>Remote Tech Inc.</td>
                            <td>
                                <span class="badge badge-primary">Remote</span>
                            </td>
                            <td>
                                <span class="badge badge-success">Published</span>
                            </td>
                        </tr>

                        <tr>
                            <td>PHP Backend Engineer</td>
                            <td>CloudWorks Ltd.</td>
                            <td>
                                <span class="badge badge-info">Full-time</span>
                            </td>
                            <td>
                                <span class="badge badge-warning">Draft</span>
                            </td>
                        </tr>

                        <tr>
                            <td>Laravel API Developer</td>
                            <td>Global SaaS Studio</td>
                            <td>
                                <span class="badge badge-primary">Remote</span>
                            </td>
                            <td>
                                <span class="badge badge-success">Published</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <a href="#" class="btn btn-sm btn-primary float-right">
                        View All Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection