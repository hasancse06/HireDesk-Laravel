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

## 📬 Phase 9 — Applicant Dashboard + Email Notification

Phase 9 adds applicant-facing status tracking and automated application status notifications.

Applicants can now clearly track the jobs they applied to, see application status updates, view selected/rejected results, and receive email notifications when an employer updates their application status. This phase demonstrates real workflow automation using Laravel Mailables, queues, and optional database notifications.

---

## ✅ Completed Features

- Applicant application dashboard improved
- Applicants can see jobs applied to
- Applicants can see application status
- Applicants can see selected/rejected status clearly
- Applicants can see application date
- Applicants can see reviewed date
- Applicants can see employer/company name
- Applicants can view detailed application status messages
- Email notification when employer shortlists an applicant
- Email notification when employer selects an applicant
- Email notification when employer rejects an applicant
- Laravel Mailable added
- Queue-ready email workflow
- Database notification support added
- Notification read controller added
- Application status email tested with Laravel log mail driver
- Queue worker tested successfully

---

## 🎯 Purpose of Phase 9

The goal of this phase is to show a complete hiring workflow:

```txt
Applicant applies to a job
Employer reviews the application
Employer shortlists/selects/rejects the applicant
Application status updates
Applicant sees updated status in dashboard
Applicant receives email notification
Database notification is created
```

This is a strong portfolio feature because it demonstrates:

```txt
Laravel Mailables
Laravel queues
Database notifications
Role-based workflow
Status-driven automation
Applicant dashboard UX
Real-world business logic
```

---

## 👨‍💻 Applicant Dashboard Improvements

The applicant dashboard/application page now shows:

```txt
Jobs applied to
Application status
Selected/rejected status
Application date
Reviewed date
Employer/company name
Job title
Job type
Workplace type
```

Applicant application page:

```txt
/applicant/applications
```

Applicant application details page:

```txt
/applicant/applications/{application}
```

---

## 📊 Applicant Application Status Cards

The applicant application dashboard includes status cards for:

```txt
Jobs Applied To
Pending Applications
Selected Applications
Rejected Applications
```

This gives applicants a clear overview of their application progress.

---

## 🏷️ Application Status Display

Applications can have these statuses:

| Status | Meaning |
|---|---|
| `pending` | Application submitted but not reviewed yet |
| `shortlisted` | Employer shortlisted the applicant |
| `selected` | Employer selected the applicant |
| `rejected` | Employer rejected the application |

Applicant-facing messages:

```txt
Selected → Congratulations message
Rejected → Not selected message
Shortlisted → Shortlisted message
Pending → Awaiting review
```

---

## 📧 Email Notification Workflow

When an employer updates an application status to:

```txt
shortlisted
selected
rejected
```

the applicant receives an email notification.

Example selected email message:

```txt
Congratulations, you have been selected for the Laravel Developer position at Example Company.
```

The email includes:

```txt
Applicant name
Job title
Company name
Application status
Application date
View Application button
```

---

## ✉️ Laravel Mailable

Phase 9 adds a queue-ready Mailable:

```txt
app/Mail/ApplicationStatusUpdatedMail.php
```

The email view is:

```txt
resources/views/emails/applications/status-updated.blade.php
```

The Mailable implements `ShouldQueue`, so emails can be processed by Laravel queue workers.

```php
class ApplicationStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
}
```

---

## 📨 Email Template

The email template uses Laravel Markdown mail components.

```txt
resources/views/emails/applications/status-updated.blade.php
```

It supports different messages based on application status:

```php
@if ($application->status === 'selected')
Congratulations, you have been selected for the **{{ $job->title }}** position at **{{ $job->company_name }}**.
@elseif ($application->status === 'rejected')
Thank you for applying for the **{{ $job->title }}** position at **{{ $job->company_name }}**. After reviewing your application, the employer has decided not to move forward with your application at this time.
@elseif ($application->status === 'shortlisted')
Good news! Your application for the **{{ $job->title }}** position at **{{ $job->company_name }}** has been shortlisted.
@else
Your application for the **{{ $job->title }}** position at **{{ $job->company_name }}** is currently pending review.
@endif
```

---

## 🔔 Database Notifications

Phase 9 also adds optional database notification support.

Notification table migration:

```bash
php artisan notifications:table
php artisan migrate
```

Notification class:

```txt
app/Notifications/ApplicationStatusUpdatedNotification.php
```

The notification stores:

```txt
application_id
job_post_id
job_title
company_name
status
message
url
```

This allows applicants to see unread application notifications inside the dashboard.

---

## 🔁 Queue Workflow

Application status emails and database notifications are queue-ready.

Recommended local `.env` settings:

```env
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

Process queued jobs locally:

```bash
php artisan queue:work --stop-when-empty
```

Because `MAIL_MAILER=log` is used locally, email output appears in:

```txt
storage/logs/laravel.log
```

Check email output:

```bash
tail -n 100 storage/logs/laravel.log
```

---

## ✅ Queue Test Result

Phase 9 was tested successfully with Laravel queue worker.

Example queue output:

```txt
App\Mail\ApplicationStatusUpdatedMail ................................ DONE
App\Notifications\ApplicationStatusUpdatedNotification ............... DONE
```

The log email correctly generated a selected applicant notification:

```txt
Congratulations, you have been selected for the Senior Ionic Angular Developer position at QuixDevs Limited.
```

---

## 🧠 Employer Application Status Automation

When an employer updates an application status, the system:

```txt
Checks employer owns the job
Updates application status
Sets reviewed_at
Sets reviewed_by
Queues email notification
Creates database notification
Redirects back with success message
```

Example logic:

```php
if ($oldStatus !== $status && in_array($status, ['shortlisted', 'selected', 'rejected'], true)) {
    Mail::to($application->applicant->email)
        ->queue(new ApplicationStatusUpdatedMail($application));

    $application->applicant->notify(
        new ApplicationStatusUpdatedNotification($application)
    );
}
```

---

## 🔐 Authorization Still Enforced

Phase 9 keeps employer authorization from Phase 8.

Employers can only update applications for their own jobs.

```php
private function authorizeEmployerJob(JobPost $job): void
{
    abort_unless($job->user_id === auth()->id(), 403);
}
```

Expected behavior:

```txt
Employer can select/reject applicants for own jobs.
Employer cannot update applications for another employer’s jobs.
Unauthorized access returns 403 Forbidden.
```

---

## 🧭 Notification Read Route

An optional notification read route was added.

```txt
POST /notifications/{notification}/read
```

Route name:

```txt
notifications.read
```

Controller:

```txt
app/Http/Controllers/NotificationController.php
```

This allows applicants to click a notification, mark it as read, and go to the related application details page.

---

## 🧭 Routes Added in Phase 9

| Method | URL | Name | Description |
|---|---|---|---|
| POST | `/notifications/{notification}/read` | `notifications.read` | Mark notification as read and redirect |

Existing application status routes now trigger email/database notifications:

| Method | URL | Name |
|---|---|---|
| PATCH | `/employer/applications/{application}/shortlist` | `employer.applications.shortlist` |
| PATCH | `/employer/applications/{application}/select` | `employer.applications.select` |
| PATCH | `/employer/applications/{application}/reject` | `employer.applications.reject` |
| PATCH | `/employer/applications/{application}/status` | `employer.applications.status` |

---

## 📁 Files Added in Phase 9

### Mail

```txt
app/Mail/ApplicationStatusUpdatedMail.php
```

### Email View

```txt
resources/views/emails/applications/status-updated.blade.php
```

### Notification

```txt
app/Notifications/ApplicationStatusUpdatedNotification.php
```

### Controller

```txt
app/Http/Controllers/NotificationController.php
```

### Migration

```txt
database/migrations/xxxx_xx_xx_xxxxxx_create_notifications_table.php
```

---

## 📝 Files Updated in Phase 9

```txt
app/Http/Controllers/Employer/ApplicationController.php
resources/views/applicant/applications/index.blade.php
resources/views/applicant/applications/show.blade.php
routes/web.php
.env
```

Recommended `.env` update:

```env
APP_NAME="HireDesk Laravel"
QUEUE_CONNECTION=database
MAIL_MAILER=log
```

After changing `.env`, clear config cache:

```bash
php artisan config:clear
php artisan optimize:clear
```

---

## 🧪 Testing Phase 9

Run migrations:

```bash
php artisan migrate
```

Clear cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

Process queued emails and notifications:

```bash
php artisan queue:work --stop-when-empty
```

Check logged email output:

```bash
tail -n 100 storage/logs/laravel.log
```

---

## ✅ Manual Testing Checklist

### Applicant Dashboard Test

Login with:

```txt
Email: applicant@hiredesk.test
Password: password
```

Open:

```txt
/applicant/applications
```

Expected result:

```txt
Applicant sees jobs applied to.
Applicant sees company name.
Applicant sees application date.
Applicant sees application status.
Applicant sees selected/rejected status clearly.
Applicant sees unread database notification if status was updated.
```

---

### Employer Select Applicant Test

Login with:

```txt
Email: employer@hiredesk.test
Password: password
```

Open:

```txt
/employer/applications/{application}
```

Click:

```txt
Select Applicant
```

Expected result:

```txt
Application status changes to selected.
reviewed_at is updated.
reviewed_by is updated.
Email notification is queued.
Database notification is created.
Success message is shown.
```

Then run:

```bash
php artisan queue:work --stop-when-empty
```

Expected queue result:

```txt
ApplicationStatusUpdatedMail DONE
ApplicationStatusUpdatedNotification DONE
```

---

### Email Log Test

Because local mail driver is set to `log`, check:

```bash
tail -n 100 storage/logs/laravel.log
```

Expected email content:

```txt
Congratulations, you have been selected for the Laravel Developer position at Example Company.
```

---

### Applicant Status Confirmation Test

Login again as the applicant and open:

```txt
/applicant/applications
/applicant/applications/{application}
```

Expected result:

```txt
Selected application shows congratulations message.
Rejected application shows not selected message.
Shortlisted application shows shortlisted message.
Pending application shows normal pending status.
```

---

## 🧰 Useful Commands

Create Mailable:

```bash
php artisan make:mail ApplicationStatusUpdatedMail --markdown=emails.applications.status-updated
```

Create notification table:

```bash
php artisan notifications:table
php artisan migrate
```

Create notification:

```bash
php artisan make:notification ApplicationStatusUpdatedNotification
```

Create notification controller:

```bash
php artisan make:controller NotificationController
```

Run queue worker:

```bash
php artisan queue:work --stop-when-empty
```

Check logs:

```bash
tail -n 100 storage/logs/laravel.log
```

Clear cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

---

## ✅ Phase 9 Status

Phase 9 is completed with:

- Applicant application status dashboard
- Jobs applied to overview
- Selected/rejected status visibility
- Application date and reviewed date display
- Company/employer name display
- Queue-ready Laravel Mailable
- Email notification on shortlist/select/reject
- Database notification support
- Notification read route
- Real workflow automation
- Local log-mail testing completed successfully

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
