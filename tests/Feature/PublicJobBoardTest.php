<?php

namespace Tests\Feature;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PublicJobBoardTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_jobs_page_loads(): void
    {
        $response = $this->get('/jobs');

        $response->assertOk();
    }

    public function test_published_job_details_page_loads(): void
    {
        Role::firstOrCreate(['name' => 'employer', 'guard_name' => 'web']);

        $employer = User::factory()->create([
            'role' => 'employer',
        ]);

        $employer->assignRole('employer');

        $job = JobPost::create([
            'user_id' => $employer->id,
            'title' => 'Laravel Developer',
            'slug' => 'laravel-developer',
            'company_name' => 'Demo Company',
            'location' => 'Remote',
            'workplace_type' => 'remote',
            'job_type' => 'full_time',
            'salary_currency' => 'USD',
            'skills_required' => 'Laravel, PHP, MySQL',
            'description' => 'This is a test job description.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('jobs.show', $job));

        $response->assertOk();
        $response->assertSee('Laravel Developer');
    }
}