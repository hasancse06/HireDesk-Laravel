@extends('layouts.admin')

@section('title', 'Applicant Profile | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Applicant Profile</h1>
            <p class="text-muted mb-0">Manage your professional profile and job application details.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Applicant Profile</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-success card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center bg-success"
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user-tie fa-3x text-white"></i>
                        </div>
                    </div>

                    <h3 class="profile-username text-center">
                        {{ auth()->user()->name }}
                    </h3>

                    <p class="text-muted text-center">
                        {{ $profile->headline ?? 'Applicant Account' }}
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Profile Completion</b>
                            <span class="float-right">{{ $profile->completionPercentage() }}%</span>
                        </li>

                        <li class="list-group-item">
                            <b>Experience</b>
                            <span class="float-right">
                                {{ $profile->experience_level ?? 'Not set' }}
                            </span>
                        </li>

                        <li class="list-group-item">
                            <b>Location</b>
                            <span class="float-right">
                                {{ $profile->location ?? 'Not set' }}
                            </span>
                        </li>
                    </ul>

                    <a href="{{ route('dashboard') }}" class="btn btn-success btn-block">
                        <b>Back to Dashboard</b>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <form method="POST" action="{{ route('applicant.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-tie mr-1"></i>
                            Professional Details
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Professional Headline <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="headline"
                                   value="{{ old('headline', $profile->headline) }}"
                                   class="form-control @error('headline') is-invalid @enderror"
                                   placeholder="Example: Laravel Developer, Frontend Engineer, UI Designer"
                                   required>

                            @error('headline')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>

                                    <input type="text"
                                           name="phone"
                                           value="{{ old('phone', $profile->phone) }}"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="+1 555 123 4567">

                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Location</label>

                                    <input type="text"
                                           name="location"
                                           value="{{ old('location', $profile->location) }}"
                                           class="form-control @error('location') is-invalid @enderror"
                                           placeholder="Example: Dhaka, Bangladesh or Remote">

                                    @error('location')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Experience Level</label>

                                    <select name="experience_level"
                                            class="form-control @error('experience_level') is-invalid @enderror">
                                        <option value="">Select experience level</option>

                                        @foreach (['Entry Level', 'Junior', 'Mid Level', 'Senior', 'Lead'] as $level)
                                            <option value="{{ $level }}" {{ old('experience_level', $profile->experience_level) === $level ? 'selected' : '' }}>
                                                {{ $level }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('experience_level')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Expected Salary</label>

                                    <input type="text"
                                           name="expected_salary"
                                           value="{{ old('expected_salary', $profile->expected_salary) }}"
                                           class="form-control @error('expected_salary') is-invalid @enderror"
                                           placeholder="Example: $3000/month or negotiable">

                                    @error('expected_salary')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Skills</label>

                            <textarea name="skills"
                                      rows="3"
                                      class="form-control @error('skills') is-invalid @enderror"
                                      placeholder="Example: Laravel, PHP, MySQL, REST API, Vue, Angular">{{ old('skills', $profile->skills) }}</textarea>

                            @error('skills')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                            <small class="text-muted">
                                Use comma-separated skills for now. Skill tags can be added in a future phase.
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Portfolio URL</label>

                            <input type="url"
                                   name="portfolio_url"
                                   value="{{ old('portfolio_url', $profile->portfolio_url) }}"
                                   class="form-control @error('portfolio_url') is-invalid @enderror"
                                   placeholder="https://yourportfolio.com">

                            @error('portfolio_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>LinkedIn URL</label>

                                    <input type="url"
                                           name="linkedin_url"
                                           value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                                           class="form-control @error('linkedin_url') is-invalid @enderror"
                                           placeholder="https://linkedin.com/in/username">

                                    @error('linkedin_url')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>GitHub URL</label>

                                    <input type="url"
                                           name="github_url"
                                           value="{{ old('github_url', $profile->github_url) }}"
                                           class="form-control @error('github_url') is-invalid @enderror"
                                           placeholder="https://github.com/username">

                                    @error('github_url')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Professional Bio</label>

                            <textarea name="bio"
                                      rows="6"
                                      class="form-control @error('bio') is-invalid @enderror"
                                      placeholder="Write a short professional summary about yourself.">{{ old('bio', $profile->bio) }}</textarea>

                            @error('bio')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i>
                            Save Applicant Profile
                        </button>

                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection