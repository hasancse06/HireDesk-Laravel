<?php

namespace App\Policies;

use App\Models\JobPost;
use App\Models\User;

class JobPostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin', 'employer']);
    }

    public function view(User $user, JobPost $jobPost): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin'])
            || $jobPost->user_id === $user->id
            || $jobPost->isPublished();
    }

    public function create(User $user): bool
    {
        return $user->hasRole('employer');
    }

    public function update(User $user, JobPost $jobPost): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin'])
            || $jobPost->user_id === $user->id;
    }

    public function delete(User $user, JobPost $jobPost): bool
    {
        return $user->hasAnyRole(['super_admin', 'admin'])
            || $jobPost->user_id === $user->id;
    }

    public function publish(User $user, JobPost $jobPost): bool
    {
        return $this->update($user, $jobPost);
    }

    public function close(User $user, JobPost $jobPost): bool
    {
        return $this->update($user, $jobPost);
    }
}