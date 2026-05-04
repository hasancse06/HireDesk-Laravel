<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    public function index(): View
    {
        $applications = auth()->user()
            ->jobApplications()
            ->with('jobPost')
            ->latest()
            ->paginate(10);

        return view('applicant.applications.index', compact('applications'));
    }

    public function create(JobPost $job): View|RedirectResponse
    {
        abort_unless($job->isPublished(), 404);

        if ($job->isExpired()) {
            return redirect()
                ->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        if ($job->hasApplied(auth()->user())) {
            return redirect()
                ->route('applicant.applications.index')
                ->with('error', 'You have already applied to this job.');
        }

        return view('applicant.applications.create', compact('job'));
    }

    public function store(Request $request, JobPost $job): RedirectResponse
    {
        abort_unless($job->isPublished(), 404);

        if ($job->isExpired()) {
            return redirect()
                ->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        if ($job->hasApplied(auth()->user())) {
            return redirect()
                ->route('applicant.applications.index')
                ->with('error', 'You have already applied to this job.');
        }

        $validated = $request->validate([
            'cover_letter' => ['required', 'string', 'min:20', 'max:10000'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'expected_salary' => ['nullable', 'string', 'max:100'],
            'availability_date' => ['nullable', 'date', 'after_or_equal:today'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume_path'] = $request->file('resume')
                ->store('resumes', 'public');
        }

        JobApplication::create([
            'job_post_id' => $job->id,
            'applicant_id' => auth()->id(),
            'cover_letter' => $validated['cover_letter'],
            'resume_path' => $validated['resume_path'] ?? null,
            'expected_salary' => $validated['expected_salary'] ?? null,
            'availability_date' => $validated['availability_date'] ?? null,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('applicant.applications.index')
            ->with('success', 'Your application has been submitted successfully.');
    }

    public function show(JobApplication $application): View
    {
        abort_unless($application->applicant_id === auth()->id(), 403);

        $application->load('jobPost');

        return view('applicant.applications.show', compact('application'));
    }
}