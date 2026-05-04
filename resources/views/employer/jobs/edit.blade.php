@extends('layouts.admin')

@section('title', 'Edit Job | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Job</h1>
            <p class="text-muted mb-0">Update your job post details and status.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('employer.jobs.index') }}">My Jobs</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
        @csrf
        @method('PUT')

        @include('employer.jobs._form', [
            'buttonText' => 'Update Job Post',
            'job' => $job,
        ])
    </form>
@endsection