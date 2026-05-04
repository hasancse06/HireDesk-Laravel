<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;

class JobApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'employer', 'applicant']);
    }

    public function view(User $user, JobApplication $application): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin'])
            || $application->applicant_id === $user->id
            || $application->jobPost?->user_id === $user->id;
    }

    public function create(User $user, JobPost $jobPost): bool
    {
        return $user->hasRole('applicant')
            && $jobPost->isPublished()
            && ! $jobPost->isExpired()
            && ! $jobPost->hasApplied($user);
    }

    public function updateStatus(User $user, JobApplication $application): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin'])
            || $application->jobPost?->user_id === $user->id;
    }

    public function delete(User $user, JobApplication $application): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin']);
    }
}