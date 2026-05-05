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

## 🔐 Phase 2 — Authentication System

Phase 2 adds a complete custom authentication system to HireDesk Laravel using Laravel's built-in session authentication features with an AdminLTE-compatible Blade UI.

This phase intentionally avoids Laravel Breeze, Tailwind, and Vite so the project remains lightweight, classic Blade-based, and easy to customize for AdminLTE dashboard projects.

### ✅ Completed Features

- Login page
- Login with remember me option
- Registration page
- Register as Applicant or Employer
- Logout functionality
- Forgot password page
- Password reset form
- Password reset token support
- Protected dashboard route
- Guest-only auth routes
- Authenticated navbar user display
- Authenticated sidebar user display
- Session-based authentication
- Role column added to users table
- Clean custom auth controllers
- AdminLTE-styled auth pages

---

## 🧭 Authentication Routes

The following authentication routes are available:

| Method | URL | Name | Description |
|---|---|---|---|
| GET | `/login` | `login` | Show login page |
| POST | `/login` | `login.store` | Process login request |
| GET | `/register` | `register` | Show registration page |
| POST | `/register` | `register.store` | Process registration request |
| POST | `/logout` | `logout` | Log out authenticated user |
| GET | `/forgot-password` | `password.request` | Show forgot password page |
| POST | `/forgot-password` | `password.email` | Send password reset link |
| GET | `/reset-password/{token}` | `password.reset` | Show reset password form |
| POST | `/reset-password` | `password.update` | Update user password |
| GET | `/dashboard` | `dashboard` | Protected dashboard page |

---

## 👤 Supported Registration Roles

During registration, users can choose one of the following account types:

| Role | Description |
|---|---|
| Applicant | Can browse jobs and apply to job posts in future phases |
| Employer | Can post jobs and review applications in future phases |

A simple `role` column has been added to the `users` table for Phase 2.

In Phase 3, this role system will be extended into a more advanced role and permission management system.

---

## 🗄️ Database Changes

Phase 2 adds the following field to the `users` table:

```txt
role
```

Default value:

```txt
applicant
```

Example user roles:

```txt
admin
employer
applicant
```

Laravel's default `password_reset_tokens` table is used for password reset functionality.

---

## 📁 Files Added in Phase 2

### Controllers

```txt
app/Http/Controllers/Auth/LoginController.php
app/Http/Controllers/Auth/RegisterController.php
app/Http/Controllers/Auth/ForgotPasswordController.php
app/Http/Controllers/Auth/ResetPasswordController.php
```

### Views

```txt
resources/views/layouts/auth.blade.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
resources/views/auth/passwords/email.blade.php
resources/views/auth/passwords/reset.blade.php
```

### Updated Files

```txt
app/Models/User.php
routes/web.php
resources/views/partials/navbar.blade.php
resources/views/partials/sidebar.blade.php
resources/views/dashboard/index.blade.php
```

### Migration

```txt
database/migrations/xxxx_xx_xx_xxxxxx_add_role_to_users_table.php
```

---

## 🧪 Testing Phase 2

You can test the authentication system using these URLs:

```txt
/register
/login
/dashboard
/logout
/forgot-password
```

Recommended test flow:

1. Register as an Applicant
2. Logout
3. Register as an Employer
4. Logout again
5. Login with one of the created users
6. Confirm dashboard access is protected
7. Test the forgot password page

---

## 📧 Password Reset Testing

The project currently uses the `log` mail driver for local development.

```env
MAIL_MAILER=log
```

When requesting a password reset link, Laravel writes the email content into the log file instead of sending a real email.

To view the reset password email locally:

```bash
tail -n 100 storage/logs/laravel.log
```

Copy the reset link from the log and open it in your browser to test the password reset flow.

---

## 🧱 Why Custom Authentication?

HireDesk Laravel uses custom authentication instead of Laravel Breeze because this project is designed around:

- AdminLTE 3.2.0
- Blade templates
- No Vite dependency
- Classic Laravel dashboard development
- Simple public asset structure
- Easy customization for job portal projects

This keeps the project lightweight and easier to adapt for traditional Laravel admin panels, shared hosting deployments, and open-source job board development.

---

## ✅ Phase 2 Status

Phase 2 is completed with:

- Custom Laravel login
- Custom Laravel registration
- Remember me support
- Logout
- Password reset flow
- Session-based authentication
- Protected dashboard
- Employer/applicant registration role
- AdminLTE-styled auth UI

---


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
