# HireDesk Laravel

**HireDesk Laravel** is a free and open-source Laravel job board starter built with **Laravel 12** and **AdminLTE 3.2.0**. It provides a clean foundation for building a custom job portal, recruitment platform, employer dashboard, or applicant tracking system.

The project is designed for developers, freelancers, agencies, and businesses who want to create a job website without starting from scratch. It includes a practical job portal structure with admin dashboards, role-based users, employer job posting, applicant applications, application review, and email notification features.

HireDesk Laravel can be used as-is for learning and development, or extended further to match custom business requirements, client projects, SaaS products, internal HR systems, or niche job boards.

---

## 🚀 Project Vision

HireDesk Laravel is created for developers who want to build a job website without starting from scratch.

The long-term goal of this project is to become a complete job board system with:

- Admin dashboard
- Role-based access control
- Employer and applicant registration
- Job posting system
- Job application workflow
- Application status management
- Email notifications
- Searchable and paginated job listings
- Clean Blade-based UI
- Production-friendly Laravel structure

This project is especially useful for building job websites for employers, agencies, startup businesses, recruitment platforms, and niche job boards.

---

## 🎯 Why This Project Exists

Many Laravel starter projects only show basic CRUD operations. HireDesk Laravel is different because it follows a realistic business workflow.

It demonstrates how Laravel can be used to build a practical web application where:

- Admins manage users and roles
- Employers create and manage job posts
- Applicants browse and apply to jobs
- Employers review applications
- Applicants track their application status
- Selected applicants receive email notifications

This makes the project useful for learning, client work, open-source collaboration, and real-world job portal development.

---

## 🧩 Current Phase

---
---

## 📨 Phase 7 — Job Application System

Phase 7 adds the complete job application workflow to HireDesk Laravel.

Applicants can now apply to published jobs with a cover letter, resume, expected salary, availability date, and portfolio URL. Employers can review applications submitted to their own jobs, update application statuses, and see real application counts. Admin users can view all applications across the platform.

---

## ✅ Completed Features

- Job application database table
- JobApplication model
- Applicants can apply to published jobs
- Cover letter submission
- Resume upload support
- Expected salary field
- Availability date field
- Portfolio URL field
- Duplicate application prevention
- Employers cannot apply to jobs
- Employers can only view applications for their own jobs
- Employers can update application status
- Admin can view all applications
- Applicant application history
- Applicant application details page
- Employer application list
- Employer application details/review page
- Employer applications by job page
- Admin application list
- Admin application details page
- Real applications count connected to job posts
- Resume storage through Laravel public disk
- Application status badges
- Sidebar links updated by role

---

## 🧾 Application Fields

Each job application includes the following fields:

| Field | Description |
|---|---|
| `job_post_id` | The job post being applied to |
| `applicant_id` | The applicant user who submitted the application |
| `cover_letter` | Applicant cover letter |
| `resume_path` | Uploaded resume file path |
| `expected_salary` | Applicant expected salary |
| `availability_date` | Date when applicant can start |
| `portfolio_url` | Applicant portfolio link |
| `status` | Current application status |
| `reviewed_at` | Date/time when employer reviewed the application |
| `reviewed_by` | Employer/admin user who reviewed the application |
| `created_at` | Application submission date |
| `updated_at` | Last update date |
| `deleted_at` | Soft delete timestamp |

---

## 🗄️ Database Table Added

Phase 7 adds the following table:

```txt
job_applications
```

### `job_applications` Table Structure

```txt
id
job_post_id
applicant_id
cover_letter
resume_path
expected_salary
availability_date
portfolio_url
status
reviewed_at
reviewed_by
created_at
updated_at
deleted_at
```

### Unique Application Rule

Each applicant can apply to the same job only once.

```txt
unique(job_post_id, applicant_id)
```

This prevents duplicate applications at the database level.

---

## 🏷️ Application Statuses

The application workflow supports four statuses:

| Status | Description |
|---|---|
| `pending` | Application has been submitted but not reviewed yet |
| `shortlisted` | Employer has shortlisted the applicant |
| `selected` | Employer has selected the applicant |
| `rejected` | Employer has rejected the application |

---

## 🔗 Model Relationships

### JobPost Model

Each job post can have many applications.

```php
public function applications(): HasMany
{
    return $this->hasMany(JobApplication::class);
}
```

The job application count now uses real application data.

```php
public function applicationsCount(): int
{
    return $this->applications()->count();
}
```

The model also checks whether a user has already applied.

```php
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
```

### User Model

Applicants can have many job applications.

```php
public function jobApplications(): HasMany
{
    return $this->hasMany(JobApplication::class, 'applicant_id');
}
```

Users can also be reviewers of applications.

```php
public function reviewedApplications(): HasMany
{
    return $this->hasMany(JobApplication::class, 'reviewed_by');
}
```

### JobApplication Model

Each application belongs to a job post.

```php
public function jobPost(): BelongsTo
{
    return $this->belongsTo(JobPost::class);
}
```

Each application belongs to an applicant.

```php
public function applicant(): BelongsTo
{
    return $this->belongsTo(User::class, 'applicant_id');
}
```

Each application may have a reviewer.

```php
public function reviewer(): BelongsTo
{
    return $this->belongsTo(User::class, 'reviewed_by');
}
```

---

## 🧠 JobApplication Model Helpers

The `JobApplication` model includes helper methods for UI display.

### Status Badge

```php
public function statusBadgeClass(): string
{
    return match ($this->status) {
        'shortlisted' => 'info',
        'selected' => 'success',
        'rejected' => 'danger',
        default => 'warning',
    };
}
```

### Status Label

```php
public function statusLabel(): string
{
    return ucfirst($this->status);
}
```

### Resume URL

```php
public function resumeUrl(): ?string
{
    if (! $this->resume_path) {
        return null;
    }

    return asset('storage/' . $this->resume_path);
}
```

---

## 🧭 Application Routes

Phase 7 adds applicant, employer, and admin application routes.

### Applicant Routes

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/applicant/applications` | `applicant.applications.index` | Applicant application history |
| GET | `/applicant/applications/{application}` | `applicant.applications.show` | Applicant application details |
| GET | `/applicant/jobs/{job:slug}/apply` | `applicant.jobs.apply.create` | Show job application form |
| POST | `/applicant/jobs/{job:slug}/apply` | `applicant.jobs.apply.store` | Submit job application |

### Employer Routes

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/employer/applications` | `employer.applications.index` | List applications for employer’s jobs |
| GET | `/employer/applications/{application}` | `employer.applications.show` | Review application details |
| PATCH | `/employer/applications/{application}/status` | `employer.applications.status` | Update application status |
| GET | `/employer/jobs/{job}/applications` | `employer.jobs.applications` | List applications for a specific job |

### Admin Routes

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/admin/applications` | `admin.applications.index` | View all platform applications |
| GET | `/admin/applications/{application}` | `admin.applications.show` | View application details as admin |

---

## 🧱 Role-Based Access Rules

Phase 7 enforces application rules based on user roles.

### Applicant Rules

```txt
Applicants can apply to published jobs.
Applicants can view their own applications.
Applicants cannot apply twice to the same job.
Applicants cannot apply to expired jobs.
Applicants cannot access employer application review pages.
```

### Employer Rules

```txt
Employers cannot apply to jobs.
Employers can only view applications submitted to their own jobs.
Employers can review application details.
Employers can update application status.
Employers cannot view applications for jobs owned by other employers.
```

### Admin Rules

```txt
Admins can view all applications across the platform.
Admins can view application details.
Admins do not submit job applications by default.
```

---

## 📎 Resume Upload

Applicants can upload a resume when applying to a job.

Supported formats:

```txt
PDF
DOC
DOCX
```

Maximum file size:

```txt
5MB
```

Resume files are stored on Laravel’s public disk:

```txt
storage/app/public/resumes
```

Public URL format:

```txt
/storage/resumes/filename.pdf
```

Run this command to make uploaded resumes publicly accessible:

```bash
php artisan storage:link
```

---

## 🧑‍💼 Applicant Workflow

Applicant flow:

```txt
Browse jobs
View job details
Click Apply Now
Submit cover letter and application details
Upload optional resume
Track application status from dashboard
View submitted application details
```

Applicant application dashboard:

```txt
/applicant/applications
```

Applicant users see:

```txt
Job title
Company name
Application status
Applied date
View details button
```

---

## 🏢 Employer Workflow

Employer flow:

```txt
Create/publish job
View application count from My Jobs
Open applications for a specific job
Review applicant details
View cover letter
View resume
View applicant profile summary
Update application status
```

Employer application dashboard:

```txt
/employer/applications
```

Employer can filter applications by status:

```txt
pending
shortlisted
selected
rejected
```

Employers can also view applications for a specific job:

```txt
/employer/jobs/{job}/applications
```

---

## 🛡️ Admin Workflow

Admin users can view all job applications across the platform.

Admin application page:

```txt
/admin/applications
```

Admin users can see:

```txt
Applicant
Job
Employer
Application status
Applied date
Application details
Reviewer information
```

---

## 🔘 Apply Button Behavior

The public job details page now supports role-aware apply behavior.

### Guest User

```txt
Shows Login to Apply button
```

### Applicant User

```txt
Shows Apply Now button if not applied
Shows Already Applied button if already applied
```

### Employer/Admin User

```txt
Does not show applicant application form
Shows dashboard-related action instead
```

---

## 📊 Dashboard Updates

Phase 7 updates dashboard statistics with application counts.

### Admin Dashboard

```txt
Total jobs
Published jobs
Draft jobs
Closed jobs
Total applications
```

### Employer Dashboard

```txt
My total jobs
My published jobs
My draft jobs
My closed jobs
Applications received
```

### Applicant Dashboard

```txt
Published jobs available
My applications
```

---

## 📁 Files Added in Phase 7

### Model

```txt
app/Models/JobApplication.php
```

### Controllers

```txt
app/Http/Controllers/Applicant/JobApplicationController.php
app/Http/Controllers/Employer/ApplicationController.php
app/Http/Controllers/Admin/ApplicationController.php
```

### Views

```txt
resources/views/applicant/applications/create.blade.php
resources/views/applicant/applications/index.blade.php
resources/views/applicant/applications/show.blade.php

resources/views/employer/applications/index.blade.php
resources/views/employer/applications/by-job.blade.php
resources/views/employer/applications/show.blade.php

resources/views/admin/applications/index.blade.php
resources/views/admin/applications/show.blade.php
```

### Migration

```txt
database/migrations/xxxx_xx_xx_xxxxxx_create_job_applications_table.php
```

---

## 📝 Files Updated in Phase 7

```txt
app/Models/JobPost.php
app/Models/User.php
app/Http/Controllers/DashboardController.php
routes/web.php
resources/views/jobs/show.blade.php
resources/views/employer/jobs/index.blade.php
resources/views/partials/sidebar.blade.php
```

---

## 🧪 Testing Phase 7

Run migrations:

```bash
php artisan migrate
```

Create public storage link:

```bash
php artisan storage:link
```

Clear cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

Check application routes:

```bash
php artisan route:list | grep applications
```

---

## ✅ Manual Testing Checklist

### Applicant Test

Login with:

```txt
Email: applicant@hiredesk.test
Password: password
```

Test:

```txt
/jobs
/jobs/{job-slug}
/applicant/jobs/{job-slug}/apply
/applicant/applications
```

Expected result:

```txt
Applicant can view published jobs.
Applicant can apply to a job.
Applicant can upload a resume.
Applicant can submit cover letter, expected salary, availability date, and portfolio URL.
Applicant is redirected to application history after applying.
Applicant cannot apply twice to the same job.
Applicant can view their own application details.
```

### Employer Test

Login with:

```txt
Email: employer@hiredesk.test
Password: password
```

Test:

```txt
/employer/jobs
/employer/applications
/employer/jobs/{job}/applications
/employer/applications/{application}
```

Expected result:

```txt
Employer can see application count on job list.
Employer can view applications submitted to their own jobs.
Employer can review applicant details.
Employer can view cover letter and resume.
Employer can update application status.
Employer cannot access applications for jobs owned by another employer.
```

### Admin Test

Login with:

```txt
Email: admin@hiredesk.test
Password: password
```

Test:

```txt
/admin/applications
/admin/applications/{application}
```

Expected result:

```txt
Admin can view all applications.
Admin can view full application details.
Admin can see applicant, employer, job, reviewer, and status information.
```

---

## 🧰 Useful Commands

Create model and migration:

```bash
php artisan make:model JobApplication -m
```

Create controllers:

```bash
php artisan make:controller Applicant/JobApplicationController
php artisan make:controller Employer/ApplicationController
php artisan make:controller Admin/ApplicationController
```

Run migrations:

```bash
php artisan migrate
```

Create storage link:

```bash
php artisan storage:link
```

Clear cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

Check routes:

```bash
php artisan route:list | grep applications
```

---

## ✅ Phase 7 Status

Phase 7 is completed with:

- Job application model
- Application database table
- Applicant application form
- Resume upload
- Duplicate application prevention
- Applicant application history
- Employer application review
- Employer status update workflow
- Admin application overview
- Real application counts on job posts
- Role-based application access
- AdminLTE-compatible application UI

---


## 🖥️ Current Tech Stack

| Technology | Version / Details |
|---|---|
| Laravel | 12.48.1 |
| PHP | 8.4.17 |
| Composer | 2.9.3 |
| Database | MySQL |
| Admin Template | AdminLTE 3.2.0 |
| Frontend | Blade, Bootstrap 4, jQuery |
| Local Development | Laravel Herd |
| Local URL | hiredesk-laravel.test |
| Cache Driver | Database |
| Queue Driver | Database |
| Session Driver | Database |
| Mail Driver | Log |

---

## 📌 Environment Snapshot

This project was initialized and tested with the following environment:

```txt
Application Name: Laravel
Laravel Version: 12.48.1
PHP Version: 8.4.17
Composer Version: 2.9.3
Environment: local
Debug Mode: ENABLED
URL: hiredesk-laravel.test
Timezone: UTC
Locale: en

Cache Driver: database
Database: mysql
Logs: stack / single
Mail: log
Queue: database
Session: database


## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/hasancse06/HireDesk-Laravel.git
cd hiredesk-laravel
```

Install PHP dependencies:

```bash
composer install
```

Copy the environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hiredesk
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

Clear and optimize:

```bash
php artisan optimize:clear
```

Run the project locally:

```bash
php artisan serve
```

Or, if you are using Laravel Herd, open:

```txt
https://hiredesk-laravel.test
```

## 🙌 Author

**M A Hasan**  
- 🔭 Full-Stack Web Developer | Laravel, WordPress, WooCommerce, Ionic Framework with Angular & REST APIs
- 🌐 About Me [https://hasan.online](https://hasan.online)
- 🎓 Instructor on [Udemy](https://www.udemy.com/user/m-a-hasan-2/)
- 🧠 Creator at [Envato](https://themeforest.net/user/hasanonline)
- ✍️ Blogger at [blog.hasan.online](https://blog.hasan.online)


## ⭐ Support This Project

If you find this useful:
- ⭐ Star the repository on GitHub
- 🔗 Share it with fellow Laravel, Ionic + Angular, WordPress, WooCommerce and Mobile App Developers
- 💡 Contribute with feedback or pull requests
