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

## 🚀 Phase 10 — Production Polish

Phase 10, Final release of HireDesk using Laravel 12.

This phase adds seeders, demo data, policies, middleware, activity logs, tests, GitHub Actions, `.env.example` cleanup, screenshots folder, installation notes, demo credentials, and database schema documentation.

---

## ✅ Completed Production Polish

- Demo seeders
- Demo admin user
- Demo employer user
- Demo applicant user
- Demo employer profile
- Demo applicant profile
- Demo job posts
- Demo job applications
- Activity logs table
- ActivityLog model
- ActivityLogger helper
- JobPost policy
- JobApplication policy
- Profile completion middleware
- Public job board feature test
- Applicant application feature test
- Employer authorization feature test
- GitHub Actions test workflow
- `.env.example` cleanup
- Database schema diagram
- Screenshots folder placeholder
- Production-ready README sections

---

## 🔐 Demo Credentials

Use these accounts to test the application.

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@hiredesk.test` | `password` |
| Employer | `employer@hiredesk.test` | `password` |
| Applicant | `applicant@hiredesk.test` | `password` |

---

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Run a specific test file:

```bash
php artisan test tests/Feature/PublicJobBoardTest.php
php artisan test tests/Feature/ApplicantApplicationTest.php
php artisan test tests/Feature/EmployerAuthorizationTest.php
```

---

## ⚙️ Fresh Installation With Demo Data

```bash
git clone https://github.com/your-username/hiredesk-laravel.git
cd hiredesk-laravel

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan storage:link

php artisan optimize:clear

php artisan serve
```

If using Laravel Herd:

```txt
http://hiredesk-laravel.test
```

---

## 📦 Production Preparation Commands

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

For queues:

```bash
php artisan queue:work
```

For local email testing:

```bash
tail -n 100 storage/logs/laravel.log
```

---

## 🧱 Database Schema

The database schema diagram is available at:

```txt
docs/database-schema.md
```

It includes:

```txt
users
employer_profiles
applicant_profiles
job_posts
job_applications
activity_logs
roles
permissions
notifications
```

---

## 📸 Screenshots

Screenshots should be added inside:

```txt
screenshots/
```

Recommended screenshots:

```txt
screenshots/public-job-board.png
screenshots/job-details.png
screenshots/company-profile.png
screenshots/login.png
screenshots/register.png
screenshots/employer-dashboard.png
screenshots/employer-jobs.png
screenshots/applicant-applications.png
screenshots/admin-users.png
```

---

## 🔁 GitHub Actions

This project includes a basic GitHub Actions workflow:

```txt
.github/workflows/tests.yml
```

It runs:

```txt
Composer install
Environment setup
SQLite database migration
Laravel feature tests
```

---

## 🧠 Production-Ready Skills Demonstrated

HireDesk Laravel demonstrates:

- Laravel 12 application architecture
- Blade and AdminLTE dashboard development
- Public job board UI
- Role-based access control
- Spatie Laravel Permission
- Employer/applicant workflows
- Policies and authorization
- Middleware
- Database design
- Migrations and seeders
- Soft deletes
- Search and filtering
- Pagination
- Resume upload
- Email notifications
- Queues
- Database notifications
- Activity logging
- Feature tests
- GitHub Actions CI workflow

---

## ✅ Final Project Status

HireDesk Laravel is now a professional open-source Laravel job board starter with:

- Public job board
- Employer job posting
- Applicant job applications
- Admin management
- Role and permission system
- Application review workflow
- Email notifications
- Demo data
- Tests
- GitHub Actions
- Production documentation

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



## Screenshots

### Login

![Login](screenshots/1-Login-HireDesk-Laravel.png)

### Register

![Register](screenshots/2-Register-HireDesk-Laravel.png)

### Browse Jobs

![Browse Jobs](screenshots/3-Browse-Jobs-HireDesk-Laravel.png)

### Employer Dashboard

![Employer Dashboard](screenshots/4-Employer-Dashboard-HireDesk-Laravel.png)

### Applicant Dashboard

![Applicant Dashboard](screenshots/5-Applicant-Dashboard-HireDesk-Laravel.png)

### Employer - My Jobs

![Employer My Jobs](screenshots/6-Employer-My-Jobs-HireDesk-Laravel.png)

### Employer - Applications

![Employer Applications](screenshots/7-Employer-Applications-HireDesk-Laravel.png)

### Employer - Applicant Details

![Employer Applicant Details](screenshots/8-Employer-Applicant-Details-HireDesk-Laravel.png)

### Applicant Profile

![Applicant Profile](screenshots/9-Applicant-Profile-HireDesk-Laravel.png)

### Applicant - My Applications

![Applicant My Applications](screenshots/10-Applicant-My-Applications-HireDesk-Laravel.png)

### Applicant - Application Details

![Applicant Application Details](screenshots/11-Applicant-Application-Details-HireDesk-Laravel.png)

### Super Admin - Users

![Super Admin Users](screenshots/12-SA-Users-HireDesk-Laravel.png)

### Super Admin - Roles

![Super Admin Roles](screenshots/13-SA-Roles-HireDesk-Laravel.png)

### Super Admin - Edit Role

![Super Admin Edit Role](screenshots/14-SA-Edit-Role-HireDesk-Laravel.png)

### Super Admin - Permissions

![Super Admin Permissions](screenshots/15-SA-Permissions-HireDesk-Laravel.png)
