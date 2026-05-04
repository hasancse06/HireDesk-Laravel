<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
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
                'stats' => [
                    'total_jobs' => JobPost::count(),
                    'published_jobs' => JobPost::where('status', 'published')->count(),
                    'draft_jobs' => JobPost::where('status', 'draft')->count(),
                    'closed_jobs' => JobPost::where('status', 'closed')->count(),
                ],
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
                'stats' => [
                    'total_jobs' => $user->jobPosts()->count(),
                    'published_jobs' => $user->jobPosts()->where('status', 'published')->count(),
                    'draft_jobs' => $user->jobPosts()->where('status', 'draft')->count(),
                    'closed_jobs' => $user->jobPosts()->where('status', 'closed')->count(),
                ],
            ]);
        }

        $profile = $user->applicantProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return view('dashboard.index', [
            'dashboardType' => 'applicant',
            'profileCompletion' => $profile->completionPercentage(),
            'profileEditUrl' => route('applicant.profile.edit'),
            'stats' => [
                'total_jobs' => JobPost::published()->count(),
                'published_jobs' => JobPost::published()->count(),
                'draft_jobs' => 0,
                'closed_jobs' => 0,
            ],
        ]);
    }
}