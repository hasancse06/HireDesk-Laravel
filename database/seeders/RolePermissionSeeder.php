<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_admin_dashboard',
            'view_employer_dashboard',
            'view_applicant_dashboard',
            'manage_jobs',
            'manage_applications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $employer = Role::firstOrCreate([
            'name' => 'employer',
            'guard_name' => 'web',
        ]);

        $applicant = Role::firstOrCreate([
            'name' => 'applicant',
            'guard_name' => 'web',
        ]);

        $superAdmin->syncPermissions($permissions);

        $admin->syncPermissions([
            'manage_users',
            'manage_roles',
            'manage_permissions',
            'view_admin_dashboard',
            'manage_jobs',
            'manage_applications',
        ]);

        $employer->syncPermissions([
            'view_employer_dashboard',
            'manage_jobs',
            'manage_applications',
        ]);

        $applicant->syncPermissions([
            'view_applicant_dashboard',
        ]);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@hiredesk.test'],
            [
                'name' => 'Super Admin',
                'role' => 'super_admin',
                'password' => Hash::make('password'),
            ]
        );

        $adminUser->syncRoles(['super_admin']);

        $employerUser = User::firstOrCreate(
            ['email' => 'employer@hiredesk.test'],
            [
                'name' => 'Demo Employer',
                'role' => 'employer',
                'password' => Hash::make('password'),
            ]
        );

        $employerUser->syncRoles(['employer']);

        $applicantUser = User::firstOrCreate(
            ['email' => 'applicant@hiredesk.test'],
            [
                'name' => 'Demo Applicant',
                'role' => 'applicant',
                'password' => Hash::make('password'),
            ]
        );

        $applicantUser->syncRoles(['applicant']);
    }
}