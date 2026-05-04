<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'company_website',
        'company_logo',
        'company_size',
        'industry',
        'location',
        'remote_friendly',
        'company_description',
    ];

    protected function casts(): array
    {
        return [
            'remote_friendly' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function completionPercentage(): int
    {
        $fields = [
            'company_name',
            'company_website',
            'company_size',
            'industry',
            'location',
            'company_description',
        ];

        $completed = collect($fields)
            ->filter(fn ($field) => filled($this->{$field}))
            ->count();

        return (int) round(($completed / count($fields)) * 100);
    }
}