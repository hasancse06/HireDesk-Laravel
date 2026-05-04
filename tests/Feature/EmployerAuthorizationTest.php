<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmployerAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cannot_view_other_employers_application(): void
    {
        Role::firstOrCreate(['name' => 'employer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'applicant', 'guard_name' => 'web']);

        $employerOne = User::factory()->create(['role' => 'employer']);
        $employerOne->assignRole('employer');

        $employerTwo = User::factory()->create(['role' => 'employer']);
        $employerTwo->assignRole('employer');

        $applicant = User::factory()->create(['role' => 'applicant']);
        $applicant->assignRole('applicant');

        $job = JobPost::create([
            'user_id' => $employerOne->id,
            'title' => 'Laravel Developer',
            'slug' => 'laravel-developer',
            'company_name' => 'Company One',
            'location' => 'Remote',
            'workplace_type' => 'remote',
            'job_type' => 'full_time',
            'salary_currency' => 'USD',
            'description' => 'Laravel role.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $application = JobApplication::create([
            'job_post_id' => $job->id,
            'applicant_id' => $applicant->id,
            'cover_letter' => 'This is a valid cover letter for testing authorization.',
            'status' => 'pending',
        ]);

        $response = $this
            ->actingAs($employerTwo)
            ->get(route('employer.applications.show', $application));

        $response->assertForbidden();
    }
}