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


## 🌐 Phase 6 — Public Job Board UI

Phase 6 adds a polished public-facing job board interface to HireDesk Laravel.

Before this phase, job browsing used the internal AdminLTE dashboard layout. Phase 6 separates the public job board experience from the authenticated dashboard experience, making the project feel like a real job portal website.

Guests, applicants, employers, and admins can now browse published jobs using a clean public UI, while employer/admin management features remain inside the dashboard.

---

## ✅ Completed Features

- Public job board layout
- Public navigation/header
- Public footer
- Polished job listing page
- Public hero section
- Search and filter panel
- Job cards with company logo placeholder
- Company name links
- Job type badges
- Remote/on-site/hybrid badges
- Salary badge
- Deadline badge
- Pagination
- Public job details page
- Public company profile page
- Public company jobs listing
- Guest users can browse published jobs
- Guest users can view job details
- Guest users can view company pages
- Logged-in applicants see an Apply Now button placeholder
- Guests see Login to Apply button
- Employers/admins can return to dashboard
- `/jobs`, `/jobs/{slug}`, and `/companies/{company}` are now public routes

---

## 🎯 Purpose of Phase 6

The goal of this phase is to make HireDesk Laravel look and feel like a real job board website.

This phase improves the user experience for:

- Guests browsing jobs
- Applicants searching for opportunities
- Employers previewing published job posts
- Developers using HireDesk Laravel as a job portal starter
- Agencies or freelancers customizing it for client projects

The project now has a clear separation between:

```txt
Public job board pages
Authenticated dashboard pages
Employer management pages
Admin management pages
```

---

## 🧭 Public Page Structure

Phase 6 introduces these public-facing pages:

| URL | Description |
|---|---|
| `/` | Redirects to the public job listing page |
| `/jobs` | Public job listing page |
| `/jobs/{slug}` | Public job details page |
| `/companies/{company}` | Public company profile and open jobs page |

---

## 🖼️ Public Layout

A new public layout was added:

```txt
resources/views/layouts/public.blade.php
```

This layout includes:

- Public navbar
- HireDesk brand
- Browse Jobs link
- Login/register links for guests
- Dashboard link for authenticated users
- Public footer
- Public CSS assets
- Meta description support

The public layout is separate from:

```txt
resources/views/layouts/admin.blade.php
resources/views/layouts/auth.blade.php
```

This keeps the public website UI separate from the AdminLTE dashboard UI.

---

## 🎨 Public CSS

A new CSS file was added for the public job board design:

```txt
public/assets/css/public.css
```

It includes styling for:

- Public navbar
- Public hero section
- Search panel
- Job cards
- Company logo placeholders
- Badges
- Job detail hero
- Job summary cards
- Company profile page
- Public footer
- Responsive mobile layout

---

## 🔎 Public Job Listing Page

The public job listing page is available at:

```txt
/jobs
```

It includes:

- Hero section
- Published job count
- Remote job count
- Hiring company count
- Search bar
- Location filter
- Workplace type filter
- Job type filter
- Job cards
- Pagination

### Search and Filter Support

The job board supports the following query filters:

| Filter | Query Parameter | Example |
|---|---|---|
| Keyword search | `search` | `/jobs?search=Laravel` |
| Location | `location` | `/jobs?location=Remote` |
| Workplace type | `workplace_type` | `/jobs?workplace_type=remote` |
| Job type | `job_type` | `/jobs?job_type=full_time` |

Example combined search:

```txt
/jobs?search=Laravel&location=Remote&workplace_type=remote&job_type=full_time
```

---

## 🧾 Public Job Cards

Each job card displays:

- Company logo placeholder
- Job title
- Company name
- Company profile link
- Location
- Application deadline
- Workplace type badge
- Job type badge
- Salary badge
- Skills required
- Posted date
- View details button

Example badge types:

```txt
Remote
On-site
Hybrid
Full-time
Part-time
Contract
Salary range
Application deadline
```

---

## 📄 Public Job Details Page

The public job details page is available at:

```txt
/jobs/{job-slug}
```

It includes:

- Job title
- Company name
- Location
- Workplace type
- Job type
- Salary range
- Application deadline
- Full job description
- Skills required
- Job summary card
- About company card
- Related jobs section
- Apply button placeholder

### Apply Button Behavior

In Phase 6, the apply button is only a placeholder because the application workflow will be added in Phase 7.

Current behavior:

```txt
Guest user → Login to Apply button
Applicant user → Apply Now button placeholder
Employer/Admin user → Go to Dashboard button
```

---

## 🏢 Public Company Page

A new company profile page was added:

```txt
/companies/{company}
```

Example:

```txt
/companies/remote-tech-inc
```

The company page includes:

- Company name
- Company logo placeholder
- Industry
- Location
- Remote-friendly status
- Company website link
- Company overview
- Company size
- Open published jobs from that company

Only published and active jobs are shown on the company page.

---

## 🧱 Public Route Changes

In previous phases, `/jobs` was inside the authenticated route group.

In Phase 6, job browsing routes were moved outside the `auth` middleware so guests can browse jobs.

### Public Routes

```php
Route::get('/', function () {
    return redirect()->route('jobs.index');
});

Route::get('/jobs', [JobBoardController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job:slug}', [JobBoardController::class, 'show'])->name('jobs.show');
Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');
```

This means:

```txt
Guests can browse jobs.
Guests can view job details.
Guests can view company pages.
Authentication is only required for dashboard, employer, applicant, and admin management routes.
```

---

## 🧭 Dashboard vs Public Job Board

Phase 6 creates a clear separation between dashboard pages and public pages.

### Public Side

```txt
/jobs
/jobs/{slug}
/companies/{company}
```

Used for:

```txt
Public job browsing
Job details
Company profile pages
Login/register CTA
```

### Dashboard Side

```txt
/dashboard
/employer/jobs
/employer/profile
/applicant/profile
/admin/users
/admin/roles
/admin/permissions
```

Used for:

```txt
Authenticated user dashboard
Employer job management
Profile management
Admin management
```

When a logged-in user clicks **Browse Jobs** from the dashboard sidebar, they are intentionally taken to the public job board page.

This is expected behavior because `/jobs` is now the public job browsing experience.

---

## 🧠 Controller Updates

### JobBoardController

The `JobBoardController` now powers the polished public job board.

```txt
app/Http/Controllers/JobBoardController.php
```

It handles:

- Public job listing
- Search
- Filters
- Public job details
- Job board statistics
- Related jobs

### CompanyController

A new controller was added:

```txt
app/Http/Controllers/CompanyController.php
```

It handles:

- Public company profile page
- Open jobs by company

---

## 📁 Files Added in Phase 6

### Layout

```txt
resources/views/layouts/public.blade.php
```

### CSS

```txt
public/assets/css/public.css
```

### Controller

```txt
app/Http/Controllers/CompanyController.php
```

### Views

```txt
resources/views/companies/show.blade.php
```

---

## 📝 Files Updated in Phase 6

```txt
app/Http/Controllers/JobBoardController.php
routes/web.php
resources/views/jobs/index.blade.php
resources/views/jobs/show.blade.php
resources/views/partials/sidebar.blade.php
```

---

## 🧪 Testing Phase 6

Clear cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

Check public job routes:

```bash
php artisan route:list | grep jobs
```

Check company routes:

```bash
php artisan route:list | grep companies
```

Expected public routes:

```txt
GET|HEAD  jobs
GET|HEAD  jobs/{job}
GET|HEAD  companies/{company}
```

---

## ✅ Manual Testing Checklist

### Guest Test

Open these URLs without logging in:

```txt
/
 /jobs
/jobs/{job-slug}
/companies/{company-slug}
```

Expected result:

```txt
Guest can browse published jobs.
Guest can view job details.
Guest can view company profile pages.
Guest sees Login to Apply button.
Guest does not see AdminLTE dashboard sidebar/topbar on public pages.
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
Applicant can browse public jobs.
Applicant can view job details.
Applicant sees Apply Now button placeholder.
Applicant can return to dashboard from public navbar.
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
/jobs
/jobs/{job-slug}
```

Expected result:

```txt
Employer can manage jobs from /employer/jobs.
Employer can preview the public job board from /jobs.
Employer sees dashboard navigation on public pages.
Employer does not see applicant apply workflow.
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
/jobs
/admin/users
```

Expected result:

```txt
Admin can access dashboard/admin pages.
Admin can browse public jobs.
Admin can return to dashboard from the public navbar.
```

---

## 🧰 Useful Commands

Create company controller:

```bash
php artisan make:controller CompanyController
```

Create company view folder:

```bash
mkdir -p resources/views/companies
```

Clear Laravel cache:

```bash
php artisan optimize:clear
php artisan route:clear
php artisan view:clear
```

Check routes:

```bash
php artisan route:list
```

Check public job routes:

```bash
php artisan route:list | grep jobs
```

Check company routes:

```bash
php artisan route:list | grep companies
```

---

## ✅ Phase 6 Status

Phase 6 is completed with:

- Public job board layout
- Polished public job listing page
- Public job details page
- Public company profile page
- Guest job browsing
- Search and filters
- Job cards
- Company logo placeholders
- Badges
- Pagination
- Public apply button placeholder
- Dashboard/public UI separation

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
