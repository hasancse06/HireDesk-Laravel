<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:employer,applicant'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create($validated);

        $user->assignRole($validated['role']);

        if ($validated['role'] === 'employer') {
            $user->employerProfile()->create([
                'company_name' => $validated['name'],
                'remote_friendly' => true,
            ]);
        }

        if ($validated['role'] === 'applicant') {
            $user->applicantProfile()->create([
                'headline' => 'New Applicant',
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Your account has been created successfully. Please complete your profile.');
    }
}