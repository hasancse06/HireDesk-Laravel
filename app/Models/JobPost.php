<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'company_name',
        'location',
        'workplace_type',
        'job_type',
        'salary_currency',
        'salary_min',
        'salary_max',
        'skills_required',
        'description',
        'status',
        'application_deadline',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'application_deadline' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where(function (Builder $query) {
                $query->whereNull('application_deadline')
                    ->orWhereDate('application_deadline', '>=', now()->toDateString());
            });
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update([
            'status' => 'draft',
        ]);
    }

    public function close(): void
    {
        $this->update([
            'status' => 'closed',
        ]);
    }

    public function workplaceTypeLabel(): string
    {
        return match ($this->workplace_type) {
            'remote' => 'Remote',
            'on_site' => 'On-site',
            'hybrid' => 'Hybrid',
            default => ucfirst($this->workplace_type),
        };
    }

    public function jobTypeLabel(): string
    {
        return match ($this->job_type) {
            'full_time' => 'Full-time',
            'part_time' => 'Part-time',
            'contract' => 'Contract',
            default => ucfirst($this->job_type),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'published' => 'success',
            'closed' => 'danger',
            default => 'secondary',
        };
    }

    public function salaryRange(): string
    {
        if (! $this->salary_min && ! $this->salary_max) {
            return 'Not specified';
        }

        if ($this->salary_min && $this->salary_max) {
            return $this->salary_currency . ' ' . number_format((float) $this->salary_min) . ' - ' . number_format((float) $this->salary_max);
        }

        if ($this->salary_min) {
            return 'From ' . $this->salary_currency . ' ' . number_format((float) $this->salary_min);
        }

        return 'Up to ' . $this->salary_currency . ' ' . number_format((float) $this->salary_max);
    }

    public function deadlineLabel(): string
    {
        if (! $this->application_deadline) {
            return 'Open until filled';
        }

        return \Carbon\Carbon::parse($this->application_deadline)->format('M d, Y');
    }

    public function isExpired(): bool
    {
        if (! $this->application_deadline) {
            return false;
        }

        return \Carbon\Carbon::parse($this->application_deadline)->isPast();
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function applicationsCount(): int
    {
        return $this->applications()->count();
    }

    public function hasApplied(?User $user = null): bool
    {
        $user = $user ?: auth()->user();

        if (! $user) {
            return false;
        }

        return $this->applications()
            ->where('applicant_id', $user->id)
            ->exists();
    }
}