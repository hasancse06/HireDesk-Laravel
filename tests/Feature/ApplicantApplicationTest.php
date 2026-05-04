<?php

namespace Tests\Feature;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ApplicantApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_applicant_can_apply_to_a_published_job(): void
    {
        Role::firstOrCreate(['name' => 'employer', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'applicant', 'guard_name' => 'web']);

        $employer = User::factory()->create(['role' => 'employer']);
        $employer->assignRole('employer');

        $applicant = User::factory()->create(['role' => 'applicant']);
        $applicant->assignRole('applicant');

        $job = JobPost::create([
            'user_id' => $employer->id,
            'title' => 'Backend Developer',
            'slug' => 'backend-developer',
            'company_name' => 'Demo Company',
            'location' => 'Remote',
            'workplace_type' => 'remote',
            'job_type' => 'full_time',
            'salary_currency' => 'USD',
            'skills_required' => 'Laravel, API',
            'description' => 'Backend developer role.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this
            ->actingAs($applicant)
            ->post(route('applicant.jobs.apply.store', $job), [
                'cover_letter' => 'I am very interested in this job and I believe my experience is a strong match.',
                'expected_salary' => 'Negotiable',
                'availability_date' => now()->addDays(7)->toDateString(),
                'portfolio_url' => 'https://example.com',
            ]);

        $response->assertRedirect(route('applicant.applications.index'));

        $this->assertDatabaseHas('job_applications', [
            'job_post_id' => $job->id,
            'applicant_id' => $applicant->id,
            'status' => 'pending',
        ]);
    }
}