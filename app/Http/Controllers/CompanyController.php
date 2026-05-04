<?php

namespace App\Http\Controllers;

use App\Models\EmployerProfile;
use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function show(string $company): View
    {
        $companyName = Str::of($company)->replace('-', ' ')->lower()->toString();

        $profile = EmployerProfile::query()
            ->with('user')
            ->whereRaw('LOWER(company_name) = ?', [$companyName])
            ->firstOrFail();

        $jobs = JobPost::query()
            ->published()
            ->where('user_id', $profile->user_id)
            ->latest('published_at')
            ->paginate(10);

        return view('companies.show', compact('profile', 'jobs'));
    }
}