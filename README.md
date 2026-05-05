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

## 🛡️ Phase 3 — Role and Permission Management

Phase 3 adds a professional role and permission management system to HireDesk Laravel using **Spatie Laravel Permission**.

This phase introduces role-based access control, permission-based feature planning, admin user management, role management, permission management, and protected admin routes. It prepares the project for future employer/applicant workflows, job posting permissions, application review permissions, and admin-level platform control.

---

## ✅ Completed Features

- Spatie Laravel Permission integration
- Role management
- Permission management
- Assign roles to users
- Admin user management
- Role-based dashboard access
- Role-protected admin routes
- Role-based sidebar menu visibility
- AdminLTE user management UI
- AdminLTE role management UI
- AdminLTE permission management UI
- Demo users seeded with roles
- Demo permissions seeded
- Permission cache reset support
- User model updated with `HasRoles`
- Registration now assigns Spatie roles automatically

---

## 📦 Package Used

This phase uses:

```txt
spatie/laravel-permission
```

Install command:

```bash
composer require spatie/laravel-permission
```

Publish package config and migrations:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Run migrations:

```bash
php artisan migrate
```

Reset permission cache:

```bash
php artisan permission:cache-reset
```

---

## 👥 System Roles

The following roles are created by default:

| Role | Description |
|---|---|
| `super_admin` | Full access to all platform features |
| `admin` | Can manage users, roles, permissions, jobs, and applications |
| `employer` | Can access employer dashboard and manage jobs/applications in future phases |
| `applicant` | Can access applicant dashboard and apply to jobs in future phases |

---

## 🔑 System Permissions

The following permissions are seeded by default:

| Permission | Description |
|---|---|
| `manage_users` | Allows managing platform users |
| `manage_roles` | Allows managing user roles |
| `manage_permissions` | Allows managing permissions |
| `view_admin_dashboard` | Allows access to admin dashboard features |
| `view_employer_dashboard` | Allows access to employer dashboard features |
| `view_applicant_dashboard` | Allows access to applicant dashboard features |
| `manage_jobs` | Allows managing job posts |
| `manage_applications` | Allows managing job applications |

---

## 👤 Demo Users

Phase 3 includes seeded demo users for testing role-based access.

| Role | Email | Password |
|---|---|---|
| Super Admin | `admin@hiredesk.test` | `password` |
| Employer | `employer@hiredesk.test` | `password` |
| Applicant | `applicant@hiredesk.test` | `password` |

---

## 🧭 Admin Routes

Admin routes are protected by role middleware.

Only users with the following roles can access admin management routes:

```txt
super_admin
admin
```

### Available Admin Routes

| Method | URL | Description |
|---|---|---|
| GET | `/admin/users` | List users |
| GET | `/admin/users/{user}/edit` | Edit user and assigned role |
| PUT/PATCH | `/admin/users/{user}` | Update user and role |
| DELETE | `/admin/users/{user}` | Delete user |
| GET | `/admin/roles` | List roles |
| GET | `/admin/roles/create` | Create role form |
| POST | `/admin/roles` | Store new role |
| GET | `/admin/roles/{role}/edit` | Edit role and permissions |
| PUT/PATCH | `/admin/roles/{role}` | Update role and permissions |
| DELETE | `/admin/roles/{role}` | Delete role |
| GET | `/admin/permissions` | List permissions |
| GET | `/admin/permissions/create` | Create permission form |
| POST | `/admin/permissions` | Store new permission |
| GET | `/admin/permissions/{permission}/edit` | Edit permission |
| PUT/PATCH | `/admin/permissions/{permission}` | Update permission |
| DELETE | `/admin/permissions/{permission}` | Delete permission |

---

## 🧱 Middleware

Spatie middleware aliases are registered in:

```txt
bootstrap/app.php
```

Middleware aliases:

```php
'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
```

Example route protection:

```php
Route::prefix('admin')
    ->name('admin.')
    ->middleware('role:super_admin|admin')
    ->group(function () {
        Route::resource('users', UserController::class)->only([
            'index',
            'edit',
            'update',
            'destroy',
        ]);

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
```

---

## 🧩 User Model Role Support

The `User` model now uses Spatie's `HasRoles` trait:

```php
use Spatie\Permission\Traits\HasRoles;
```

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
}
```

Helper methods were added for cleaner role checks:

```php
public function primaryRoleName(): string
{
    return $this->roles()->first()?->name ?? $this->role ?? 'applicant';
}

public function isSuperAdmin(): bool
{
    return $this->hasRole('super_admin');
}

public function isAdmin(): bool
{
    return $this->hasAnyRole(['super_admin', 'admin']);
}

public function isEmployer(): bool
{
    return $this->hasRole('employer') || $this->role === 'employer';
}

public function isApplicant(): bool
{
    return $this->hasRole('applicant') || $this->role === 'applicant';
}
```

---

## 📝 Registration Role Assignment

When a new user registers as an `employer` or `applicant`, the selected role is now assigned through Spatie Permission.

Example:

```php
$user = User::create($validated);

$user->assignRole($validated['role']);
```

This keeps the simple `role` column and Spatie role system aligned during registration.

---

## 📁 Files Added in Phase 3

### Controllers

```txt
app/Http/Controllers/Admin/UserController.php
app/Http/Controllers/Admin/RoleController.php
app/Http/Controllers/Admin/PermissionController.php
```

### Seeders

```txt
database/seeders/RolePermissionSeeder.php
```

### Views

```txt
resources/views/admin/users/index.blade.php
resources/views/admin/users/edit.blade.php

resources/views/admin/roles/index.blade.php
resources/views/admin/roles/create.blade.php
resources/views/admin/roles/edit.blade.php

resources/views/admin/permissions/index.blade.php
resources/views/admin/permissions/create.blade.php
resources/views/admin/permissions/edit.blade.php

resources/views/partials/alerts.blade.php
```

### Updated Files

```txt
app/Models/User.php
app/Http/Controllers/Auth/RegisterController.php
bootstrap/app.php
database/seeders/DatabaseSeeder.php
routes/web.php
resources/views/layouts/admin.blade.php
resources/views/partials/sidebar.blade.php
resources/views/dashboard/index.blade.php
```

---

## 🗄️ Database Tables Added by Spatie

Spatie Laravel Permission adds the following tables:

```txt
permissions
roles
model_has_permissions
model_has_roles
role_has_permissions
```

These tables power the role and permission management system.

---

## 🧪 Testing Phase 3

After running migrations and seeders, test using the seeded users.

### Super Admin Test

Login with:

```txt
Email: admin@hiredesk.test
Password: password
```

Confirm access to:

```txt
/dashboard
/admin/users
/admin/roles
/admin/permissions
```

Expected result:

```txt
Super Admin can access all admin management pages.
```

### Employer Test

Login with:

```txt
Email: employer@hiredesk.test
Password: password
```

Confirm access to:

```txt
/dashboard
```

Confirm restricted access to:

```txt
/admin/users
/admin/roles
/admin/permissions
```

Expected result:

```txt
Employer can access dashboard but cannot access admin management pages.
```

### Applicant Test

Login with:

```txt
Email: applicant@hiredesk.test
Password: password
```

Confirm access to:

```txt
/dashboard
```

Confirm restricted access to:

```txt
/admin/users
/admin/roles
/admin/permissions
```

Expected result:

```txt
Applicant can access dashboard but cannot access admin management pages.
```

---

## 🧰 Useful Commands

Install Spatie Laravel Permission:

```bash
composer require spatie/laravel-permission
```

Publish Spatie config and migrations:

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Run migrations:

```bash
php artisan migrate
```

Run role and permission seeder:

```bash
php artisan db:seed --class=RolePermissionSeeder
```

Reset permission cache:

```bash
php artisan permission:cache-reset
```

Clear Laravel cache:

```bash
php artisan optimize:clear
```

Check routes:

```bash
php artisan route:list
```

Check admin routes only:

```bash
php artisan route:list | grep admin
```

---

## ✅ Phase 3 Status

Phase 3 is completed with:

- Role-based access control
- Permission-based structure
- Admin user management
- Role CRUD
- Permission CRUD
- Spatie Laravel Permission integration
- Role-protected admin routes
- Role-aware dashboard access
- AdminLTE-compatible management screens

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
