@extends('layouts.admin')

@section('title', 'Post a Job | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Post a Job</h1>
            <p class="text-muted mb-0">Create a new job post for applicants.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.jobs.index') }}">My Jobs</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('employer.jobs.store') }}">
        @csrf

        @include('employer.jobs._form', [
            'buttonText' => 'Create Job Post',
            'employerProfile' => $employerProfile,
        ])
    </form>
@endsection