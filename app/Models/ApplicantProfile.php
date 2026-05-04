<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id',
        'headline',
        'phone',
        'location',
        'experience_level',
        'expected_salary',
        'portfolio_url',
        'linkedin_url',
        'github_url',
        'resume_path',
        'skills',
        'bio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completionPercentage(): int
    {
        $fields = [
            'headline',
            'phone',
            'location',
            'experience_level',
            'portfolio_url',
            'skills',
            'bio',
        ];

        $completed = collect($fields)
            ->filter(fn ($field) => filled($this->{$field}))
            ->count();

        return (int) round(($completed / count($fields)) * 100);
    }
}