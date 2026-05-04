<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-briefcase mr-1"></i>
                    Job Details
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Job Title <span class="text-danger">*</span></label>

                    <input type="text"
                           name="title"
                           value="{{ old('title', $job->title ?? '') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Example: Senior Laravel Developer"
                           required>

                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Company Name <span class="text-danger">*</span></label>

                    <input type="text"
                           name="company_name"
                           value="{{ old('company_name', $job->company_name ?? $employerProfile->company_name ?? auth()->user()->name) }}"
                           class="form-control @error('company_name') is-invalid @enderror"
                           required>

                    @error('company_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Location</label>

                    <input type="text"
                           name="location"
                           value="{{ old('location', $job->location ?? $employerProfile->location ?? 'Remote') }}"
                           class="form-control @error('location') is-invalid @enderror"
                           placeholder="Example: Remote, New York, London, Dhaka">

                    @error('location')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Skills Required</label>

                    <textarea name="skills_required"
                              rows="3"
                              class="form-control @error('skills_required') is-invalid @enderror"
                              placeholder="Example: Laravel, PHP, MySQL, REST API, Vue, Angular">{{ old('skills_required', $job->skills_required ?? '') }}</textarea>

                    @error('skills_required')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted">
                        Use comma-separated skills for now.
                    </small>
                </div>

                <div class="form-group">
                    <label>Job Description <span class="text-danger">*</span></label>

                    <textarea name="description"
                              rows="10"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Describe responsibilities, requirements, benefits, and application instructions."
                              required>{{ old('description', $job->description ?? '') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog mr-1"></i>
                    Job Settings
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Workplace Type <span class="text-danger">*</span></label>

                    <select name="workplace_type"
                            class="form-control @error('workplace_type') is-invalid @enderror"
                            required>
                        @foreach ([
                            'remote' => 'Remote',
                            'on_site' => 'On-site',
                            'hybrid' => 'Hybrid',
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('workplace_type', $job->workplace_type ?? 'remote') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('workplace_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Job Type <span class="text-danger">*</span></label>

                    <select name="job_type"
                            class="form-control @error('job_type') is-invalid @enderror"
                            required>
                        @foreach ([
                            'full_time' => 'Full-time',
                            'part_time' => 'Part-time',
                            'contract' => 'Contract',
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('job_type', $job->job_type ?? 'full_time') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('job_type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>

                    <select name="status"
                            class="form-control @error('status') is-invalid @enderror"
                            required>
                        @foreach ([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'closed' => 'Closed',
                        ] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $job->status ?? 'draft') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <hr>

                <div class="form-group">
                    <label>Salary Currency</label>

                    <input type="text"
                           name="salary_currency"
                           value="{{ old('salary_currency', $job->salary_currency ?? 'USD') }}"
                           class="form-control @error('salary_currency') is-invalid @enderror"
                           maxlength="10">

                    @error('salary_currency')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Minimum Salary</label>

                    <input type="number"
                           step="0.01"
                           name="salary_min"
                           value="{{ old('salary_min', $job->salary_min ?? '') }}"
                           class="form-control @error('salary_min') is-invalid @enderror">

                    @error('salary_min')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Maximum Salary</label>

                    <input type="number"
                           step="0.01"
                           name="salary_max"
                           value="{{ old('salary_max', $job->salary_max ?? '') }}"
                           class="form-control @error('salary_max') is-invalid @enderror">

                    @error('salary_max')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Application Deadline</label>

                    <input type="date"
                           name="application_deadline"
                           value="{{ old('application_deadline', isset($job) && $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}"
                           class="form-control @error('application_deadline') is-invalid @enderror">

                    @error('application_deadline')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-save mr-1"></i>
                    {{ $buttonText ?? 'Save Job' }}
                </button>

                <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary btn-block">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>