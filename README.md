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

## 👥 Phase 4 — Employer and Applicant Profiles

Phase 4 adds role-specific profile management for employers and applicants.

This phase improves the registration and dashboard experience by creating dedicated profile records for each user type. Employers now have company profiles, applicants now have professional profiles, and dashboards can display profile completion progress based on the logged-in user’s role.

---

## ✅ Completed Features

- Register as Employer
- Register as Applicant
- Employer profile table
- Applicant profile table
- Automatic employer profile creation after registration
- Automatic applicant profile creation after registration
- Employer profile edit page
- Applicant profile edit page
- Profile completion percentage
- Profile-specific dashboard card
- Role-specific profile routes
- Role-specific sidebar profile links
- Profile-specific dashboard data
- Seeded demo employer profile
- Seeded demo applicant profile

---

## 🧑‍💼 Employer Profile

Employers can manage company and hiring-related details.

### Employer Profile Fields

| Field | Description |
|---|---|
| `company_name` | Employer/company name |
| `company_website` | Company website URL |
| `company_logo` | Placeholder field for future logo upload |
| `company_size` | Number of employees |
| `industry` | Business industry/category |
| `location` | Company location or remote location |
| `remote_friendly` | Indicates if the company supports remote work |
| `company_description` | Short company overview |

### Employer Profile Route

```txt
/employer/profile
```

Only users with the `employer` role can access this route.

---

## 👨‍💻 Applicant Profile

Applicants can manage their professional job-seeker profile.

### Applicant Profile Fields

| Field | Description |
|---|---|
| `headline` | Professional title or headline |
| `phone` | Contact phone number |
| `location` | Applicant location |
| `experience_level` | Entry, Junior, Mid, Senior, Lead, etc. |
| `expected_salary` | Expected salary or compensation note |
| `portfolio_url` | Personal portfolio link |
| `linkedin_url` | LinkedIn profile link |
| `github_url` | GitHub profile link |
| `resume_path` | Placeholder field for future resume upload |
| `skills` | Applicant skills, currently stored as text |
| `bio` | Professional summary |

### Applicant Profile Route

```txt
/applicant/profile
```

Only users with the `applicant` role can access this route.

---

## 🗄️ Database Tables Added

Phase 4 adds two new profile tables.

```txt
employer_profiles
applicant_profiles
```

### `employer_profiles`

```txt
id
user_id
company_name
company_website
company_logo
company_size
industry
location
remote_friendly
company_description
created_at
updated_at
```

### `applicant_profiles`

```txt
id
user_id
headline
phone
location
experience_level
expected_salary
portfolio_url
linkedin_url
github_url
resume_path
skills
bio
created_at
updated_at
```

Each profile table has a unique `user_id`, so each user can only have one role-specific profile.

---

## 🔗 Model Relationships

### User Model

The `User` model now supports employer and applicant profile relationships.

```php
public function employerProfile(): HasOne
{
    return $this->hasOne(EmployerProfile::class);
}

public function applicantProfile(): HasOne
{
    return $this->hasOne(ApplicantProfile::class);
}
```

### EmployerProfile Model

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

### ApplicantProfile Model

```php
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
```

---

## 📊 Profile Completion

Both employer and applicant profiles include a simple profile completion calculation.

Example:

```php
public function completionPercentage(): int
{
    $fields = [
        'company_name',
        'company_website',
        'company_size',
        'industry',
        'location',
        'company_description',
    ];

    $completed = collect($fields)
        ->filter(fn ($field) => filled($this->{$field}))
        ->count();

    return (int) round(($completed / count($fields)) * 100);
}
```

The dashboard displays a profile completion card for employer and applicant users.

---

## 🧭 Profile Routes

Phase 4 adds role-protected profile routes.

| Method | URL | Name | Role |
|---|---|---|---|
| GET | `/employer/profile` | `employer.profile.edit` | employer |
| PUT | `/employer/profile` | `employer.profile.update` | employer |
| GET | `/applicant/profile` | `applicant.profile.edit` | applicant |
| PUT | `/applicant/profile` | `applicant.profile.update` | applicant |

---

## 🧱 Role-Based Access

Profile routes are protected using Spatie role middleware.

```php
Route::prefix('employer')
    ->name('employer.')
    ->middleware('role:employer')
    ->group(function () {
        Route::get('/profile', [EmployerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [EmployerProfileController::class, 'update'])->name('profile.update');
    });

Route::prefix('applicant')
    ->name('applicant.')
    ->middleware('role:applicant')
    ->group(function () {
        Route::get('/profile', [ApplicantProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ApplicantProfileController::class, 'update'])->name('profile.update');
    });
```

Expected behavior:

```txt
Employer users can access employer profile routes.
Applicant users can access applicant profile routes.
Employer users cannot access applicant profile routes.
Applicant users cannot access employer profile routes.
Admin users manage the platform but do not use employer/applicant profile routes by default.
```

---

## 🧭 Dashboard Controller

Phase 4 introduces a dedicated dashboard controller.

```txt
app/Http/Controllers/DashboardController.php
```

The dashboard now detects the authenticated user’s role and returns dashboard-specific data.

Dashboard types:

```txt
admin
employer
applicant
```

Example behavior:

```txt
Super Admin/Admin → Admin dashboard
Employer → Employer dashboard with company profile completion
Applicant → Applicant dashboard with professional profile completion
```

---

## 📝 Registration Profile Creation

When a user registers, the system automatically creates the correct profile type.

### Employer Registration

```php
if ($validated['role'] === 'employer') {
    $user->employerProfile()->create([
        'company_name' => $validated['name'],
        'remote_friendly' => true,
    ]);
}
```

### Applicant Registration

```php
if ($validated['role'] === 'applicant') {
    $user->applicantProfile()->create([
        'headline' => 'New Applicant',
    ]);
}
```

This ensures every employer and applicant starts with a profile immediately after registration.

---

## 📁 Files Added in Phase 4

### Models

```txt
app/Models/EmployerProfile.php
app/Models/ApplicantProfile.php
```

### Controllers

```txt
app/Http/Controllers/DashboardController.php
app/Http/Controllers/Employer/ProfileController.php
app/Http/Controllers/Applicant/ProfileController.php
```

### Views

```txt
resources/views/employer/profile/edit.blade.php
resources/views/applicant/profile/edit.blade.php
```

### Migrations

```txt
database/migrations/xxxx_xx_xx_xxxxxx_create_employer_profiles_table.php
database/migrations/xxxx_xx_xx_xxxxxx_create_applicant_profiles_table.php
```

---

## 📝 Files Updated in Phase 4

```txt
app/Models/User.php
app/Http/Controllers/Auth/RegisterController.php
database/seeders/RolePermissionSeeder.php
routes/web.php
resources/views/dashboard/index.blade.php
resources/views/partials/sidebar.blade.php
```

---

## 👤 Demo Profile Data

Phase 4 updates the demo employer and applicant users with profile records.

### Demo Employer

```txt
Email: employer@hiredesk.test
Password: password
Company: Remote Tech Inc.
Industry: Software Development
Location: Remote
```

### Demo Applicant

```txt
Email: applicant@hiredesk.test
Password: password
Headline: Laravel Developer
Skills: Laravel, PHP, MySQL, REST API, Blade, AdminLTE
Location: Remote
```

---

## 🧪 Testing Phase 4

Run migrations:

```bash
php artisan migrate
```

Seed demo profile data:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

Clear cache:

```bash
php artisan optimize:clear
```

Check profile routes:

```bash
php artisan route:list | grep profile
```

Expected profile routes:

```txt
GET|HEAD  employer/profile
PUT       employer/profile
GET|HEAD  applicant/profile
PUT       applicant/profile
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
/dashboard
/employer/profile
```

Expected result:

```txt
Employer can access dashboard.
Employer can access company profile page.
Employer can update company details.
Employer sees profile completion card on dashboard.
Employer cannot access /applicant/profile.
```

### Applicant Test

Login with:

```txt
Email: applicant@hiredesk.test
Password: password
```

Test:

```txt
/dashboard
/applicant/profile
```

Expected result:

```txt
Applicant can access dashboard.
Applicant can access professional profile page.
Applicant can update professional details.
Applicant sees profile completion card on dashboard.
Applicant cannot access /employer/profile.
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
/admin/users
/admin/roles
/admin/permissions
```

Expected result:

```txt
Admin can access dashboard and admin management pages.
Admin profile-specific employer/applicant card is not shown by default.
```

---

## 🧰 Useful Commands

Create models and migrations:

```bash
php artisan make:model EmployerProfile -m
php artisan make:model ApplicantProfile -m
```

Create dashboard controller:

```bash
php artisan make:controller DashboardController
```

Create profile controllers:

```bash
php artisan make:controller Employer/ProfileController
php artisan make:controller Applicant/ProfileController
```

Run migrations:

```bash
php artisan migrate
```

Seed demo data:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

Clear cache:

```bash
php artisan optimize:clear
```

Check routes:

```bash
php artisan route:list
```

Check profile routes:

```bash
php artisan route:list | grep profile
```

---

## ✅ Phase 4 Status

Phase 4 is completed with:

- Employer profile system
- Applicant profile system
- Automatic profile creation after registration
- Profile completion calculation
- Role-specific profile routes
- Role-specific sidebar links
- Role-specific dashboard data
- AdminLTE-compatible profile edit pages
- Seeded demo employer and applicant profiles

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
