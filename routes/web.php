<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return view('dashboard.index', [
                'dashboardType' => 'admin',
            ]);
        }

        if ($user->hasRole('employer')) {
            return view('dashboard.index', [
                'dashboardType' => 'employer',
            ]);
        }

        return view('dashboard.index', [
            'dashboardType' => 'applicant',
        ]);
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

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