<?php

namespace App\Providers;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Policies\JobApplicationPolicy;
use App\Policies\JobPostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(JobPost::class, JobPostPolicy::class);
        Gate::policy(JobApplication::class, JobApplicationPolicy::class);
    }
}