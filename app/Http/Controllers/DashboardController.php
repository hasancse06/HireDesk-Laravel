<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            return view('dashboard.index', [
                'dashboardType' => 'admin',
                'profileCompletion' => 100,
            ]);
        }

        if ($user->hasRole('employer')) {
            $profile = $user->employerProfile()->firstOrCreate([
                'user_id' => $user->id,
            ]);

            return view('dashboard.index', [
                'dashboardType' => 'employer',
                'profileCompletion' => $profile->completionPercentage(),
                'profileEditUrl' => route('employer.profile.edit'),
            ]);
        }

        $profile = $user->applicantProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return view('dashboard.index', [
            'dashboardType' => 'applicant',
            'profileCompletion' => $profile->completionPercentage(),
            'profileEditUrl' => route('applicant.profile.edit'),
        ]);
    }
}