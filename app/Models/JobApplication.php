<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_post_id',
        'applicant_id',
        'cover_letter',
        'resume_path',
        'expected_salary',
        'availability_date',
        'portfolio_url',
        'status',
        'reviewed_at',
        'reviewed_by',
    ];

    protected function casts(): array
    {
        return [
            'availability_date' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'shortlisted' => 'info',
            'selected' => 'success',
            'rejected' => 'danger',
            default => 'warning',
        };
    }

    public function statusLabel(): string
    {
        return ucfirst($this->status);
    }

    public function resumeUrl(): ?string
    {
        if (! $this->resume_path) {
            return null;
        }

        return asset('storage/' . $this->resume_path);
    }
}