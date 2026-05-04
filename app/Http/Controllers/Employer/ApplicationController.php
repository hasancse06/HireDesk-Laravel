<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $applications = JobApplication::query()
            ->with(['jobPost', 'applicant.applicantProfile'])
            ->whereHas('jobPost', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('employer.applications.index', compact('applications'));
    }

    public function byJob(JobPost $job): View
    {
        $this->authorizeEmployerJob($job);

        $applications = $job->applications()
            ->with('applicant.applicantProfile')
            ->latest()
            ->paginate(10);

        return view('employer.applications.by-job', compact('job', 'applications'));
    }

    public function show(JobApplication $application): View
    {
        $application->load(['jobPost', 'applicant.applicantProfile']);

        $this->authorizeEmployerJob($application->jobPost);

        return view('employer.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application): RedirectResponse
    {
        $application->load('jobPost');

        $this->authorizeEmployerJob($application->jobPost);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,shortlisted,selected,rejected'],
        ]);

        $application->update([
            'status' => $validated['status'],
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Application status updated successfully.');
    }

    private function authorizeEmployerJob(JobPost $job): void
    {
        abort_unless($job->user_id === auth()->id(), 403);
    }
}