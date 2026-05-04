<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function primaryRoleName(): string
    {
        return $this->roles()->first()?->name ?? $this->role ?? 'applicant';
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['super_admin', 'admin']);
    }

    public function isEmployer(): bool
    {
        return $this->hasRole('employer') || $this->role === 'employer';
    }

    public function isApplicant(): bool
    {
        return $this->hasRole('applicant') || $this->role === 'applicant';
    }

    public function employerProfile(): HasOne
    {
        return $this->hasOne(EmployerProfile::class);
    }

    public function applicantProfile(): HasOne
    {
        return $this->hasOne(ApplicantProfile::class);
    }

    public function profileCompletionPercentage(): int
    {
        if ($this->isEmployer()) {
            return $this->employerProfile?->completionPercentage() ?? 0;
        }

        if ($this->isApplicant()) {
            return $this->applicantProfile?->completionPercentage() ?? 0;
        }

        return 100;
    }

    public function profileEditRoute(): string
    {
        if ($this->isEmployer()) {
            return route('employer.profile.edit');
        }

        if ($this->isApplicant()) {
            return route('applicant.profile.edit');
        }

        return route('dashboard');
    }

    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'applicant_id');
    }

    public function reviewedApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'reviewed_by');
    }
}