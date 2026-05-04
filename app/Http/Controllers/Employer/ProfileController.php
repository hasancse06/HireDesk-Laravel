<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = auth()->user()
            ->employerProfile()
            ->firstOrCreate([
                'user_id' => auth()->id(),
            ]);

        return view('employer.profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:100'],
            'industry' => ['nullable', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:150'],
            'remote_friendly' => ['nullable', 'boolean'],
            'company_description' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['remote_friendly'] = $request->boolean('remote_friendly');

        auth()->user()
            ->employerProfile()
            ->updateOrCreate(
                ['user_id' => auth()->id()],
                $validated
            );

        return redirect()
            ->route('employer.profile.edit')
            ->with('success', 'Employer profile updated successfully.');
    }
}