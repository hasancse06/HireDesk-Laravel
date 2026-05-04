<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = auth()->user()
            ->applicantProfile()
            ->firstOrCreate([
                'user_id' => auth()->id(),
            ]);

        return view('applicant.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'headline' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:150'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'expected_salary' => ['nullable', 'string', 'max:100'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'skills' => ['nullable', 'string', 'max:3000'],
            'bio' => ['nullable', 'string', 'max:5000'],
        ]);

        auth()->user()
            ->applicantProfile()
            ->updateOrCreate(
                ['user_id' => auth()->id()],
                $validated
            );

        return redirect()
            ->route('applicant.profile.edit')
            ->with('success', 'Applicant profile updated successfully.');
    }
}