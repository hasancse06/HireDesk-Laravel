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

        /*
        |--------------------------------------------------------------------------
        | Dynamic Demo Jobs
        |--------------------------------------------------------------------------
        */

        $jobTitles = [
            'Senior Laravel Developer',
            'Full Stack Laravel Developer',
            'PHP Backend Developer',
            'Ionic Angular Developer',
            'Angular Frontend Developer',
            'WooCommerce API Developer',
            'WordPress Plugin Developer',
            'REST API Developer',
            'SaaS Backend Engineer',
            'Laravel Admin Panel Developer',
            'Mobile App Developer',
            'Vue Laravel Developer',
            'React Frontend Developer',
            'DevOps Engineer',
            'QA Automation Engineer',
            'Technical Support Engineer',
            'Product Manager',
            'UI UX Designer',
            'Database Administrator',
            'Software Project Manager',
        ];

        $companies = [
            'QuixDevs Limited',
            'CodeCraft Studio',
            'BrightLayer Technologies',
            'PixelForge Labs',
            'RemoteStack Solutions',
            'BluePeak Digital',
            'NextWave Software',
            'CloudNova Systems',
            'AppBridge Technologies',
            'HireDesk Demo Company',
        ];

        $locations = [
            'Remote',
            'Dhaka',
            'London',
            'New York',
            'Berlin',
            'Toronto',
            'Dubai',
            'Singapore',
            'Sydney',
            'Amsterdam',
        ];

        $workplaceTypes = [
            'remote',
            'on_site',
            'hybrid',
        ];

        $jobTypes = [
            'full_time',
            'part_time',
            'contract',
        ];

        $skillsPool = [
            'Laravel, PHP, MySQL, REST API, Blade',
            'Ionic, Angular, TypeScript, Capacitor, REST API',
            'WooCommerce, WordPress, PHP, Plugin Development, REST API',
            'React, JavaScript, Tailwind CSS, API Integration',
            'Vue.js, Laravel, Inertia, MySQL, Git',
            'Node.js, Express, PostgreSQL, API Development',
            'AWS, Docker, Linux, CI/CD, Deployment',
            'QA Testing, PHPUnit, Pest, Automation, Laravel',
            'Figma, UI Design, UX Research, Prototyping',
            'Project Management, Agile, Scrum, Client Communication',
        ];

        $descriptions = [
            'We are looking for a skilled professional to join our team and help build scalable, reliable, and user-friendly software products.',
            'The selected candidate will work closely with our product and engineering teams to deliver high-quality features and improvements.',
            'This role requires strong problem-solving skills, clean coding practices, and the ability to work independently in a remote-friendly environment.',
            'You will be responsible for developing, maintaining, and improving modern web applications, APIs, and internal tools.',
            'We need someone who can understand business requirements, convert them into technical solutions, and deliver production-ready work.',
        ];

        $statuses = [
            'published',
            'published',
            'published',
            'published',
            'draft',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $title = $jobTitles[array_rand($jobTitles)];
            $company = $companies[array_rand($companies)];
            $location = $locations[array_rand($locations)];
            $workplaceType = $workplaceTypes[array_rand($workplaceTypes)];
            $jobType = $jobTypes[array_rand($jobTypes)];
            $skills = $skillsPool[array_rand($skillsPool)];
            $description = $descriptions[array_rand($descriptions)];
            $status = $statuses[array_rand($statuses)];

            $salaryMin = rand(800, 4000);
            $salaryMax = $salaryMin + rand(1000, 5000);

            $uniqueTitle = $title . ' #' . $i;

            $job = JobPost::updateOrCreate(
                [
                    'slug' => Str::slug($uniqueTitle),
                ],
                [
                    'user_id' => $employer->id,
                    'title' => $uniqueTitle,
                    'company_name' => $company,
                    'location' => $location,
                    'workplace_type' => $workplaceType,
                    'job_type' => $jobType,
                    'salary_currency' => 'USD',
                    'salary_min' => $salaryMin,
                    'salary_max' => $salaryMax,
                    'skills_required' => $skills,
                    'description' => $description,
                    'status' => $status,
                    'application_deadline' => now()->addDays(rand(7, 60))->toDateString(),
                    'published_at' => $status === 'published' ? now()->subDays(rand(0, 15)) : null,
                ]
            );

            if ($job->isPublished() && $i <= 30) {
                JobApplication::updateOrCreate(
                    [
                        'job_post_id' => $job->id,
                        'applicant_id' => $applicant->id,
                    ],
                    [
                        'cover_letter' => 'I am interested in this role because it matches my Laravel, API, and full-stack development experience.',
                        'expected_salary' => 'Negotiable',
                        'availability_date' => now()->addDays(rand(3, 20))->toDateString(),
                        'portfolio_url' => 'https://hasan.online',
                        'status' => $i % 5 === 0 ? 'selected' : 'pending',
                        'reviewed_at' => $i % 5 === 0 ? now() : null,
                        'reviewed_by' => $i % 5 === 0 ? $employer->id : null,
                    ]
                );
            }
        }
    }
}