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

## 💼 Phase 5 — Job Posting System

Phase 5 adds the core job posting system to HireDesk Laravel.

Employers can now create and manage job posts, while applicants can browse published jobs, search jobs, filter job listings, and view job details. This phase turns HireDesk Laravel from an authentication/profile-based dashboard into a functional job board foundation.

> Note: Laravel already uses a default `jobs` table for queued jobs. To avoid conflict, this project uses a dedicated `job_posts` table for job board listings.

---

## ✅ Completed Features

- Job post database table
- JobPost model
- Employer job CRUD
- Employers can create job posts
- Employers can edit their own job posts
- Employers can delete their own job posts
- Employers can publish job posts
- Employers can unpublish job posts
- Employers can close job posts
- Employers can see applications count placeholder
- Applicants can browse published jobs
- Applicants can search jobs
- Applicants can filter jobs by workplace type, location, and job type
- Applicants can view job details
- Published-only job board listing
- Draft and closed jobs hidden from applicant browse page
- SEO-friendly job slug URLs
- Dashboard job stats
- AdminLTE-compatible job management UI
- AdminLTE-compatible job browsing UI

---

## 🧾 Job Fields

Each job post includes the following fields:

| Field | Description |
|---|---|
| `title` | Job title |
| `slug` | SEO-friendly unique job URL slug |
| `user_id` | Employer user who created the job |
| `company_name` | Company or employer name |
| `location` | Job location |
| `workplace_type` | Remote, On-site, or Hybrid |
| `job_type` | Full-time, Part-time, or Contract |
| `salary_currency` | Salary currency such as USD |
| `salary_min` | Minimum salary |
| `salary_max` | Maximum salary |
| `skills_required` | Required skills for the job |
| `description` | Full job description |
| `status` | Draft, Published, or Closed |
| `application_deadline` | Last date to apply |
| `published_at` | Date/time when job was published |
| `deleted_at` | Soft delete timestamp |

---

## 🗄️ Database Table Added

Phase 5 adds the following table:

```txt
job_posts
```

### `job_posts` Table Structure

```txt
id
user_id
title
slug
company_name
location
workplace_type
job_type
salary_currency
salary_min
salary_max
skills_required
description
status
application_deadline
published_at
created_at
updated_at
deleted_at
```

### Job Status Values

```txt
draft
published
closed
```

### Workplace Type Values

```txt
remote
on_site
hybrid
```

### Job Type Values

```txt
full_time
part_time
contract
```

---

## 🔗 Model Relationships

### User Model

Employers can have many job posts.

```php
public function jobPosts(): HasMany
{
    return $this->hasMany(JobPost::class);
}
```

### JobPost Model

Each job post belongs to an employer user.

```php
public function employer(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
```

---

## 🧠 JobPost Model Helpers

The `JobPost` model includes helper methods for cleaner UI and business logic.

```php
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
```

### Publish / Unpublish / Close

```php
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
```

### Published Scope

Only published and non-expired jobs appear in the applicant job board.

```php
public function scopePublished(Builder $query): Builder
{
    return $query
        ->where('status', 'published')
        ->where(function (Builder $query) {
            $query->whereNull('application_deadline')
                ->orWhereDate('application_deadline', '>=', now()->toDateString());
        });
}
```

### Salary and Deadline Helpers

```php
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
```

---

## 🧭 Job Routes

Phase 5 adds employer job management routes and job board browsing routes.

### Job Board Routes

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/jobs` | `jobs.index` | Browse published jobs |
| GET | `/jobs/{job:slug}` | `jobs.show` | View job details |

### Employer Job Management Routes

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/employer/jobs` | `employer.jobs.index` | Employer job list |
| GET | `/employer/jobs/create` | `employer.jobs.create` | Create job form |
| POST | `/employer/jobs` | `employer.jobs.store` | Store new job |
| GET | `/employer/jobs/{job}/edit` | `employer.jobs.edit` | Edit job form |
| PUT/PATCH | `/employer/jobs/{job}` | `employer.jobs.update` | Update job |
| DELETE | `/employer/jobs/{job}` | `employer.jobs.destroy` | Delete job |
| PATCH | `/employer/jobs/{job}/publish` | `employer.jobs.publish` | Publish job |
| PATCH | `/employer/jobs/{job}/unpublish` | `employer.jobs.unpublish` | Move job back to draft |
| PATCH | `/employer/jobs/{job}/close` | `employer.jobs.close` | Close job |

---

## 🧱 Role-Based Access

Employer job management routes are protected using Spatie role middleware.

```php
Route::prefix('employer')
    ->name('employer.')
    ->middleware('role:employer')
    ->group(function () {
        Route::resource('jobs', EmployerJobPostController::class)->except(['show']);

        Route::patch('/jobs/{job}/publish', [EmployerJobPostController::class, 'publish'])
            ->name('jobs.publish');

        Route::patch('/jobs/{job}/unpublish', [EmployerJobPostController::class, 'unpublish'])
            ->name('jobs.unpublish');

        Route::patch('/jobs/{job}/close', [EmployerJobPostController::class, 'close'])
            ->name('jobs.close');
    });
```

Expected behavior:

```txt
Employer users can create, edit, delete, publish, unpublish, and close their own jobs.
Employer users cannot edit jobs created by another employer.
Applicant users can browse published jobs.
Draft jobs are hidden from the applicant job board.
Closed jobs are hidden from the applicant job board.
```

---

## 🧑‍💼 Employer Job Management

Employers can manage jobs from:

```txt
/employer/jobs
```

Employer actions:

```txt
Create job
Edit job
Delete job
Publish job
Unpublish job
Close job
View applications count placeholder
```

After creating or updating a job, the employer is redirected back to:

```txt
/employer/jobs
```

This allows the employer to quickly review the job list and manage post status.

---

## 👨‍💻 Applicant Job Browsing

Applicants can browse published jobs from:

```txt
/jobs
```

Available browsing features:

```txt
Search by job title
Search by company name
Search by skills
Search by description
Filter by location
Filter by workplace type
Filter by job type
View job details
```

Job details page:

```txt
/jobs/{job-slug}
```

The application button is currently disabled because the application workflow will be added in a future phase.

---

## 🔎 Search and Filter Support

The job board supports filtering by:

| Filter | Query Parameter | Example |
|---|---|---|
| Search keyword | `search` | `/jobs?search=Laravel` |
| Location | `location` | `/jobs?location=Remote` |
| Workplace type | `workplace_type` | `/jobs?workplace_type=remote` |
| Job type | `job_type` | `/jobs?job_type=full_time` |

Example combined filter:

```txt
/jobs?search=Laravel&location=Remote&workplace_type=remote&job_type=full_time
```

---

## 📊 Dashboard Job Stats

Phase 5 updates the dashboard with job-related statistics.

### Admin Dashboard Stats

```txt
Total jobs
Published jobs
Draft jobs
Closed jobs
```

### Employer Dashboard Stats

```txt
My total jobs
My published jobs
My draft jobs
My closed jobs
```

### Applicant Dashboard Stats

```txt
Published jobs available
```

---

## 📁 Files Added in Phase 5

### Model

```txt
app/Models/JobPost.php
```

### Controllers

```txt
app/Http/Controllers/Employer/JobPostController.php
app/Http/Controllers/JobBoardController.php
```

### Views

```txt
resources/views/employer/jobs/index.blade.php
resources/views/employer/jobs/create.blade.php
resources/views/employer/jobs/edit.blade.php
resources/views/employer/jobs/_form.blade.php

resources/views/jobs/index.blade.php
resources/views/jobs/show.blade.php
```

### Migration

```txt
database/migrations/xxxx_xx_xx_xxxxxx_create_job_posts_table.php
```

---

## 📝 Files Updated in Phase 5

```txt
app/Models/User.php
app/Http/Controllers/DashboardController.php
routes/web.php
resources/views/partials/sidebar.blade.php
resources/views/dashboard/index.blade.php
public/assets/css/app.css
```

---

## 🧪 Testing Phase 5

Run migrations:

```bash
php artisan migrate
```

Clear cache:

```bash
php artisan optimize:clear
```

Check job routes:

```bash
php artisan route:list | grep jobs
```

Expected job routes:

```txt
GET|HEAD   jobs
GET|HEAD   jobs/{job}
GET|HEAD   employer/jobs
POST       employer/jobs
GET|HEAD   employer/jobs/create
GET|HEAD   employer/jobs/{job}/edit
PUT|PATCH  employer/jobs/{job}
DELETE     employer/jobs/{job}
PATCH      employer/jobs/{job}/publish
PATCH      employer/jobs/{job}/unpublish
PATCH      employer/jobs/{job}/close
```

---

## ✅ Manual Testing Checklist

### Employer Test

Login with:

```txt
Email: employer@hiredesk.test
Password: password
```

Test:

```txt
/employer/jobs
/employer/jobs/create
```

Create a job post:

```txt
Title: Senior Laravel Developer
Company: Remote Tech Inc.
Location: Remote
Workplace Type: Remote
Job Type: Full-time
Salary Currency: USD
Salary Min: 3000
Salary Max: 5000
Skills Required: Laravel, PHP, MySQL, REST API
Status: Published
Application Deadline: Leave empty or choose a future date
Description: We are hiring a Laravel developer for a remote SaaS project.
```

Expected result:

```txt
Employer can create a job.
Employer is redirected to /employer/jobs after creating a job.
Employer can edit the job.
Employer is redirected to /employer/jobs after updating a job.
Employer can publish/unpublish the job.
Employer can close the job.
Employer can delete the job.
Employer can see applications count placeholder.
```

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
```

Expected result:

```txt
Applicant can browse published jobs.
Applicant can search jobs.
Applicant can filter jobs.
Applicant can view job details.
Applicant cannot access employer job management routes.
Draft jobs are not visible.
Closed jobs are not visible.
Expired jobs are not visible.
```

### Admin Test

Login with:

```txt
Email: admin@hiredesk.test
Password: password
```

Test:

```txt
/dashboard
```

Expected result:

```txt
Admin dashboard shows total jobs, published jobs, draft jobs, and closed jobs.
```

---

## 🧰 Useful Commands

Create model and migration:

```bash
php artisan make:model JobPost -m
```

Create controllers:

```bash
php artisan make:controller Employer/JobPostController
php artisan make:controller JobBoardController
```

Run migrations:

```bash
php artisan migrate
```

Clear cache:

```bash
php artisan optimize:clear
```

Check job routes:

```bash
php artisan route:list | grep jobs
```

---

## ✅ Phase 5 Status

Phase 5 is completed with:

- Job post database structure
- Employer job management
- Published job board listing
- Search and filtering
- Job details page
- Role-based job access
- Employer-only job CRUD
- Publish/unpublish/close workflow
- Dashboard job stats
- AdminLTE-compatible job UI

---

## 🔜 Next Phase

### Phase 6 — Public Job Board UI

Planned features:

- Public homepage
- Public job listing page
- Public job details page
- Better job cards
- SEO-friendly job browsing
- Guest users can browse jobs
- Applicants can apply after login
- Public navigation/header
- Job portal landing page

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
git clone https://github.com/your-username/hiredesk-laravel.git
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
