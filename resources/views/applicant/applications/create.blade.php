@extends('layouts.admin')

@section('title', 'Apply to Job | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-8">
            <h1>Apply to Job</h1>
            <p class="text-muted mb-0">
                {{ $job->title }} at {{ $job->company_name }}
            </p>
        </div>

        <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('jobs.index') }}">Jobs</a>
                </li>
                <li class="breadcrumb-item active">Apply</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <form method="POST"
                      action="{{ route('applicant.jobs.apply.store', $job) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-paper-plane mr-1"></i>
                            Application Details
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Cover Letter <span class="text-danger">*</span></label>

                            <textarea name="cover_letter"
                                      rows="8"
                                      class="form-control @error('cover_letter') is-invalid @enderror"
                                      placeholder="Write a short cover letter explaining why you are a good fit for this role."
                                      required>{{ old('cover_letter') }}</textarea>

                            @error('cover_letter')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Resume</label>

                            <input type="file"
                                   name="resume"
                                   class="form-control @error('resume') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx">

                            @error('resume')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror

                            <small class="text-muted">
                                Accepted formats: PDF, DOC, DOCX. Max size: 5MB.
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Expected Salary</label>

                            <input type="text"
                                   name="expected_salary"
                                   value="{{ old('expected_salary') }}"
                                   class="form-control @error('expected_salary') is-invalid @enderror"
                                   placeholder="Example: $3000/month or negotiable">

                            @error('expected_salary')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Availability Date</label>

                            <input type="date"
                                   name="availability_date"
                                   value="{{ old('availability_date') }}"
                                   class="form-control @error('availability_date') is-invalid @enderror">

                            @error('availability_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Portfolio URL</label>

                            <input type="url"
                                   name="portfolio_url"
                                   value="{{ old('portfolio_url', auth()->user()->applicantProfile?->portfolio_url) }}"
                                   class="form-control @error('portfolio_url') is-invalid @enderror"
                                   placeholder="https://yourportfolio.com">

                            @error('portfolio_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane mr-1"></i>
                            Submit Application
                        </button>

                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Job Summary</h3>
                </div>

                <div class="card-body">
                    <p><strong>{{ $job->title }}</strong></p>
                    <p class="text-muted">{{ $job->company_name }}</p>

                    <hr>

                    <p><strong>Location:</strong><br>{{ $job->location ?? 'Remote' }}</p>
                    <p><strong>Workplace:</strong><br>{{ $job->workplaceTypeLabel() }}</p>
                    <p><strong>Type:</strong><br>{{ $job->jobTypeLabel() }}</p>
                    <p><strong>Salary:</strong><br>{{ $job->salaryRange() }}</p>
                    <p><strong>Deadline:</strong><br>{{ $job->deadlineLabel() }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection