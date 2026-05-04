<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $applications = JobApplication::query()
            ->with(['jobPost.employer', 'applicant'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application): View
    {
        $application->load(['jobPost.employer', 'applicant.applicantProfile', 'reviewer']);

        return view('admin.applications.show', compact('application'));
    }
}