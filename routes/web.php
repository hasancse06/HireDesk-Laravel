<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Applicant\ProfileController as ApplicantProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employer\ProfileController as EmployerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

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
});