<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@hiredesk.test'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->syncRoles(['super_admin']);

        $employer = User::firstOrCreate(
            ['email' => 'employer@hiredesk.test'],
            [
                'name' => 'Demo Employer',
                'role' => 'employer',
                'password' => Hash::make('password'),
            ]
        );

        $employer->syncRoles(['employer']);

        $employer->employerProfile()->updateOrCreate(
            ['user_id' => $employer->id],
            [
                'company_name' => 'QuixDevs Limited',
                'company_website' => 'https://hasan.online',
                'company_size' => '11-50',
                'industry' => 'Software Development',
                'location' => 'Remote',
                'remote_friendly' => true,
                'company_description' => 'QuixDevs Limited is a demo software company used to showcase the employer workflow in HireDesk Laravel.',
            ]
        );

        $applicant = User::firstOrCreate(
            ['email' => 'applicant@hiredesk.test'],
            [
                'name' => 'Applicant Hasan',
                'role' => 'applicant',
                'password' => Hash::make('password'),
            ]
        );

        $applicant->syncRoles(['applicant']);

        $applicant->applicantProfile()->updateOrCreate(
            ['user_id' => $applicant->id],
            [
                'headline' => 'Laravel and Ionic Angular Developer',
                'phone' => '+880 1700 000000',
                'location' => 'Remote',
                'experience_level' => 'Senior',
                'expected_salary' => 'Negotiable',
                'portfolio_url' => 'https://hasan.online',
                'linkedin_url' => 'https://linkedin.com',
                'github_url' => 'https://github.com/hasancse06',
                'skills' => 'Laravel, PHP, MySQL, REST API, Ionic, Angular, WooCommerce',
                'bio' => 'Demo applicant profile for testing job applications and hiring workflows.',
            ]
        );

        $jobs = [
            [
                'title' => 'Senior Laravel Developer',
                'location' => 'Remote',
                'workplace_type' => 'remote',
                'job_type' => 'full_time',
                'salary_min' => 3000,
                'salary_max' => 5000,
                'skills_required' => 'Laravel, PHP, MySQL, REST API, Blade',
                'description' => 'We are looking for a Senior Laravel Developer to build scalable backend systems, APIs, and admin dashboards.',
                'status' => 'published',
            ],
            [
                'title' => 'Ionic Angular Developer',
                'location' => 'Remote',
                'workplace_type' => 'remote',
                'job_type' => 'contract',
                'salary_min' => 2000,
                'salary_max' => 4000,
                'skills_required' => 'Ionic, Angular, TypeScript, REST API, Capacitor',
                'description' => 'We need an Ionic Angular Developer to build mobile apps connected to Laravel and WordPress APIs.',
                'status' => 'published',
            ],
            [
                'title' => 'WooCommerce API Developer',
                'location' => 'Hybrid',
                'workplace_type' => 'hybrid',
                'job_type' => 'part_time',
                'salary_min' => 1500,
                'salary_max' => 3000,
                'skills_required' => 'WooCommerce, WordPress, PHP, REST API, Laravel',
                'description' => 'Build WooCommerce integrations, REST API extensions, and Laravel-based sync workflows.',
                'status' => 'draft',
            ],
        ];

        foreach ($jobs as $data) {
            $job = JobPost::updateOrCreate(
                [
                    'slug' => Str::slug($data['title']),
                ],
                [
                    'user_id' => $employer->id,
                    'title' => $data['title'],
                    'company_name' => 'QuixDevs Limited',
                    'location' => $data['location'],
                    'workplace_type' => $data['workplace_type'],
                    'job_type' => $data['job_type'],
                    'salary_currency' => 'USD',
                    'salary_min' => $data['salary_min'],
                    'salary_max' => $data['salary_max'],
                    'skills_required' => $data['skills_required'],
                    'description' => $data['description'],
                    'status' => $data['status'],
                    'application_deadline' => now()->addDays(30)->toDateString(),
                    'published_at' => $data['status'] === 'published' ? now() : null,
                ]
            );

            if ($job->isPublished()) {
                JobApplication::updateOrCreate(
                    [
                        'job_post_id' => $job->id,
                        'applicant_id' => $applicant->id,
                    ],
                    [
                        'cover_letter' => 'I am interested in this role because it matches my Laravel, API, and full-stack development experience.',
                        'expected_salary' => 'Negotiable',
                        'availability_date' => now()->addDays(7)->toDateString(),
                        'portfolio_url' => 'https://hasan.online',
                        'status' => $job->title === 'Senior Laravel Developer' ? 'selected' : 'pending',
                        'reviewed_at' => $job->title === 'Senior Laravel Developer' ? now() : null,
                        'reviewed_by' => $job->title === 'Senior Laravel Developer' ? $employer->id : null,
                    ]
                );
            }
        }
    }
}