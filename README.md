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

## 🧑‍💼 Phase 8 — Employer Application Review

Phase 8 improves the employer-side application review workflow.

Employers can now see stronger application statistics on their dashboard, navigate from job posts to applications, open detailed applicant profiles, and quickly shortlist, select, or reject applicants. This phase also strengthens authorization by ensuring employers can only view and manage applications submitted to their own job posts.

---

## ✅ Completed Features

- Employer dashboard application statistics
- Total jobs count
- Published jobs count
- Total applications count
- Pending applications count
- Selected applicants count
- Rejected applicants count
- Improved `My Jobs → Applications → Applicant Details` flow
- Better employer applications by job page
- Better employer applicant details page
- Applicant name and email display
- Applicant resume link
- Applicant cover letter display
- Applicant skills display
- Applicant portfolio link display
- Applicant GitHub link display
- Applicant LinkedIn link display
- Application status badge
- Shortlist button
- Select Applicant button
- Reject Application button
- Manual status update form
- Strong employer authorization checks

---

## 🎯 Purpose of Phase 8

The goal of this phase is to make the employer review experience more practical and realistic.

Employers should be able to:

```txt
Open dashboard
See application stats
Go to My Jobs
Click application count
View applicants for a job
Open applicant details
Review resume, cover letter, skills, and portfolio
Shortlist, select, or reject the applicant
```

This phase demonstrates real Laravel authorization and business workflow handling.

---

## 📊 Employer Dashboard Stats

The employer dashboard now shows:

```txt
Total Jobs
Published Jobs
Total Applications
Pending Applications
Selected Applicants
Rejected Applicants
```

These stats are calculated only from the logged-in employer’s own jobs.

Example logic:

```php
$applicationQuery = JobApplication::whereHas('jobPost', function ($query) use ($user) {
    $query->where('user_id', $user->id);
});
```

Then each stat is counted from the employer-owned application query:

```php
'applications' => (clone $applicationQuery)->count(),
'pending_applications' => (clone $applicationQuery)->where('status', 'pending')->count(),
'selected_applications' => (clone $applicationQuery)->where('status', 'selected')->count(),
'rejected_applications' => (clone $applicationQuery)->where('status', 'rejected')->count(),
```

---

## 🧭 Employer Review Flow

Phase 8 improves the employer review journey.

### Main Flow

```txt
/employer/jobs
        ↓
Click application count
        ↓
/employer/jobs/{job}/applications
        ↓
Click Applicant Details
        ↓
/employer/applications/{application}
        ↓
Shortlist / Select / Reject
```

This creates a clear, real-world hiring workflow.

---

## 🧾 Employer Applications by Job

The page:

```txt
/employer/jobs/{job}/applications
```

shows applications for a specific job post.

It includes:

- Job title
- Company name
- Workplace type
- Job type
- Salary range
- Application deadline
- Total applications count
- Applicant name
- Applicant email
- Applicant skills
- Application status
- Expected salary
- Applied date
- Applicant Details button

This page is only accessible by the employer who owns the job.

---

## 👤 Employer Applicant Details Page

The page:

```txt
/employer/applications/{application}
```

shows a detailed review screen for an applicant.

It includes:

| Section | Details |
|---|---|
| Applicant Information | Name, email, headline |
| Professional Profile | Experience level, location, skills, bio |
| Application Details | Expected salary, availability date |
| Links | Resume, portfolio, GitHub, LinkedIn |
| Cover Letter | Full applicant cover letter |
| Status Panel | Current status, applied date, reviewed date |
| Quick Actions | Shortlist, Select, Reject |
| Job Details | Job title, company, type, workplace, public job link |

---

## 🏷️ Application Review Actions

Employers can update application status using quick action buttons.

### Shortlist Applicant

```txt
PATCH /employer/applications/{application}/shortlist
```

Route name:

```txt
employer.applications.shortlist
```

### Select Applicant

```txt
PATCH /employer/applications/{application}/select
```

Route name:

```txt
employer.applications.select
```

### Reject Application

```txt
PATCH /employer/applications/{application}/reject
```

Route name:

```txt
employer.applications.reject
```

### Manual Status Update

```txt
PATCH /employer/applications/{application}/status
```

Route name:

```txt
employer.applications.status
```

---

## 🏷️ Application Statuses

Phase 8 continues using the existing application statuses:

| Status | Meaning |
|---|---|
| `pending` | Application submitted but not reviewed yet |
| `shortlisted` | Employer marked the applicant as a possible fit |
| `selected` | Employer selected the applicant |
| `rejected` | Employer rejected the application |

---

## 🔐 Employer Authorization

Phase 8 strengthens employer authorization.

Employers can only view or update applications for jobs they own.

Authorization logic:

```php
private function authorizeEmployerJob(JobPost $job): void
{
    abort_unless($job->user_id === auth()->id(), 403);
}
```

This check is applied before:

```txt
Viewing applications by job
Viewing applicant details
Updating application status
Shortlisting applicant
Selecting applicant
Rejecting applicant
```

Expected behavior:

```txt
Employer can manage applications for their own jobs.
Employer cannot access applications from another employer’s jobs.
Unauthorized access returns 403 Forbidden.
```

---

## 🧠 Employer Application Controller Updates

The employer application controller was improved with quick status actions.

Controller:

```txt
app/Http/Controllers/Employer/ApplicationController.php
```

### Quick Action Methods

```php
public function shortlist(JobApplication $application): RedirectResponse
{
    return $this->changeStatus($application, 'shortlisted', 'Applicant shortlisted successfully.');
}

public function select(JobApplication $application): RedirectResponse
{
    return $this->changeStatus($application, 'selected', 'Applicant selected successfully.');
}

public function reject(JobApplication $application): RedirectResponse
{
    return $this->changeStatus($application, 'rejected', 'Application rejected successfully.');
}
```

### Shared Status Change Method

```php
private function changeStatus(JobApplication $application, string $status, string $message): RedirectResponse
{
    $application->load('jobPost');

    $this->authorizeEmployerJob($application->jobPost);

    abort_unless(
        in_array($status, ['pending', 'shortlisted', 'selected', 'rejected'], true),
        422
    );

    $application->update([
        'status' => $status,
        'reviewed_at' => now(),
        'reviewed_by' => auth()->id(),
    ]);

    return redirect()
        ->route('employer.applications.show', $application)
        ->with('success', $message);
}
```

---

## 🧭 Routes Added in Phase 8

Phase 8 adds quick employer application review routes.

| Method | URL | Name | Description |
|---|---|---|---|
| PATCH | `/employer/applications/{application}/shortlist` | `employer.applications.shortlist` | Shortlist an applicant |
| PATCH | `/employer/applications/{application}/select` | `employer.applications.select` | Select an applicant |
| PATCH | `/employer/applications/{application}/reject` | `employer.applications.reject` | Reject an application |

Existing employer application routes:

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/employer/applications` | `employer.applications.index` | List applications for employer’s jobs |
| GET | `/employer/applications/{application}` | `employer.applications.show` | View applicant details |
| PATCH | `/employer/applications/{application}/status` | `employer.applications.status` | Manual status update |
| GET | `/employer/jobs/{job}/applications` | `employer.jobs.applications` | View applications for a specific job |

---

## 🧩 Dashboard Updates

The dashboard view now includes employer-specific application review cards.

For employer users, the dashboard shows:

```txt
Pending Applications
Selected Applicants
Rejected Applicants
```

Each card links to filtered employer applications:

```txt
/employer/applications?status=pending
/employer/applications?status=selected
/employer/applications?status=rejected
```

---

## 🧾 My Jobs Application Count

The employer job list now makes the application count clickable.

Location:

```txt
/employer/jobs
```

Application count button links to:

```txt
/employer/jobs/{job}/applications
```

This makes the review flow simple:

```txt
My Jobs → Applications → Applicant Details
```

---

## 📁 Files Updated in Phase 8

```txt
app/Http/Controllers/DashboardController.php
app/Http/Controllers/Employer/ApplicationController.php
routes/web.php
resources/views/dashboard/index.blade.php
resources/views/employer/jobs/index.blade.php
resources/views/employer/applications/index.blade.php
resources/views/employer/applications/by-job.blade.php
resources/views/employer/applications/show.blade.php
```

---

## 🧪 Testing Phase 8

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

Expected employer routes:

```txt
GET|HEAD  employer/applications
GET|HEAD  employer/applications/{application}
PATCH     employer/applications/{application}/status
PATCH     employer/applications/{application}/shortlist
PATCH     employer/applications/{application}/select
PATCH     employer/applications/{application}/reject
GET|HEAD  employer/jobs/{job}/applications
```

---

## ✅ Manual Testing Checklist

### Employer Dashboard Test

Login with:

```txt
Email: employer@hiredesk.test
Password: password
```

Open:

```txt
/dashboard
```

Expected result:

```txt
Employer sees total jobs.
Employer sees published jobs.
Employer sees total applications.
Employer sees pending applications.
Employer sees selected applicants.
Employer sees rejected applicants.
```

---

### Employer Review Flow Test

Open:

```txt
/employer/jobs
```

Click the application count button.

Expected flow:

```txt
My Jobs
→ Applications for selected job
→ Applicant Details
```

On applicant details page, confirm these are visible:

```txt
Applicant name
Applicant email
Resume link
Cover letter
Skills
Portfolio link
GitHub link
LinkedIn link
Application status
Shortlist button
Select Applicant button
Reject Application button
Manual status update form
```

---

### Status Action Test

From the applicant details page, test:

```txt
Shortlist
Select Applicant
Reject Application
Manual status update
```

Expected result:

```txt
Application status updates correctly.
reviewed_at is updated.
reviewed_by is updated.
Success message is shown.
Employer stays on the applicant details page.
```

---

### Authorization Test

Expected authorization behavior:

```txt
Employer can access applications for their own jobs.
Employer cannot access applications for another employer’s jobs.
Unauthorized access returns 403 Forbidden.
```

---

## ✅ Phase 8 Status

Phase 8 is completed with:

- Employer dashboard review statistics
- Improved employer job-to-application flow
- Improved applications by job page
- Improved applicant details page
- Resume, cover letter, skills, portfolio, GitHub, and LinkedIn visibility
- Quick shortlist/select/reject actions
- Manual status update
- Strong employer authorization
- AdminLTE-compatible review UI

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
