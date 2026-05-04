@extends('layouts.admin')

@section('title', 'Employer Profile | HireDesk Laravel')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Employer Profile</h1>
            <p class="text-muted mb-0">Manage your company profile and hiring details.</p>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">Employer Profile</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img img-fluid img-circle d-flex align-items-center justify-content-center bg-primary"
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-building fa-3x text-white"></i>
                        </div>
                    </div>

                    <h3 class="profile-username text-center">
                        {{ $profile->company_name ?? auth()->user()->name }}
                    </h3>

                    <p class="text-muted text-center">
                        {{ $profile->industry ?? 'Employer Account' }}
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Profile Completion</b>
                            <span class="float-right">{{ $profile->completionPercentage() }}%</span>
                        </li>

                        <li class="list-group-item">
                            <b>Remote Friendly</b>
                            <span class="float-right">
                                {{ $profile->remote_friendly ? 'Yes' : 'No' }}
                            </span>
                        </li>

                        <li class="list-group-item">
                            <b>Location</b>
                            <span class="float-right">
                                {{ $profile->location ?? 'Not set' }}
                            </span>
                        </li>
                    </ul>

                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-block">
                        <b>Back to Dashboard</b>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <form method="POST" action="{{ route('employer.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-building mr-1"></i>
                            Company Details
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="company_name"
                                   value="{{ old('company_name', $profile->company_name) }}"
                                   class="form-control @error('company_name') is-invalid @enderror"
                                   placeholder="Example: Remote Tech Inc."
                                   required>

                            @error('company_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Company Website</label>

                            <input type="url"
                                   name="company_website"
                                   value="{{ old('company_website', $profile->company_website) }}"
                                   class="form-control @error('company_website') is-invalid @enderror"
                                   placeholder="https://example.com">

                            @error('company_website')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Company Size</label>

                                    <select name="company_size"
                                            class="form-control @error('company_size') is-invalid @enderror">
                                        <option value="">Select company size</option>

                                        @foreach (['1-10', '11-50', '51-200', '201-500', '500+'] as $size)
                                            <option value="{{ $size }}" {{ old('company_size', $profile->company_size) === $size ? 'selected' : '' }}>
                                                {{ $size }} employees
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('company_size')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Industry</label>

                                    <input type="text"
                                           name="industry"
                                           value="{{ old('industry', $profile->industry) }}"
                                           class="form-control @error('industry') is-invalid @enderror"
                                           placeholder="Example: Software, E-commerce, Healthcare">

                                    @error('industry')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Location</label>

                            <input type="text"
                                   name="location"
                                   value="{{ old('location', $profile->location) }}"
                                   class="form-control @error('location') is-invalid @enderror"
                                   placeholder="Example: New York, USA or Remote">

                            @error('location')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       name="remote_friendly"
                                       value="1"
                                       id="remote_friendly"
                                       class="custom-control-input"
                                       {{ old('remote_friendly', $profile->remote_friendly) ? 'checked' : '' }}>

                                <label class="custom-control-label" for="remote_friendly">
                                    This company is remote friendly
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Company Description</label>

                            <textarea name="company_description"
                                      rows="6"
                                      class="form-control @error('company_description') is-invalid @enderror"
                                      placeholder="Write a short description about your company, culture, and hiring goals.">{{ old('company_description', $profile->company_description) }}</textarea>

                            @error('company_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>
                            Save Employer Profile
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