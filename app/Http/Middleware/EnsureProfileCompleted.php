<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if ($user->hasRole('employer')) {
            $profile = $user->employerProfile;

            if (! $request->routeIs('employer.profile.*') && blank($profile?->company_name)) {
                return redirect()
                    ->route('employer.profile.edit')
                    ->with('error', 'Please complete your employer profile before continuing.');
            }
        }

        if ($user->hasRole('applicant')) {
            $profile = $user->applicantProfile;

            if (! $request->routeIs('applicant.profile.*') && blank($profile?->headline)) {
                return redirect()
                    ->route('applicant.profile.edit')
                    ->with('error', 'Please complete your applicant profile before continuing.');
            }
        }

        return $next($request);
    }
}