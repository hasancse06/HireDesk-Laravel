<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobPostController extends Controller
{
    public function index(): View
    {
        $jobs = auth()->user()
            ->jobPosts()
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create(): View
    {
        $employerProfile = auth()->user()->employerProfile;

        return view('employer.jobs.create', compact('employerProfile'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateJob($request);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        JobPost::create($validated);

        return redirect()
            ->route('employer.jobs.index')
            ->with('success', 'Job post created successfully.');
    }

    public function edit(JobPost $job): View
    {
        $this->authorizeEmployerJob($job);

        return view('employer.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobPost $job): RedirectResponse
    {
        $this->authorizeEmployerJob($job);

        $validated = $this->validateJob($request);

        if ($job->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $job->id);
        }

        $job->update($validated);

        return redirect()
            ->route('employer.jobs.index')
            ->with('success', 'Job post updated successfully.');
    }

    public function destroy(JobPost $job): RedirectResponse
    {
        $this->authorizeEmployerJob($job);

        $job->delete();

        return redirect()
            ->route('employer.jobs.index')
            ->with('success', 'Job post deleted successfully.');
    }

    public function publish(JobPost $job): RedirectResponse
    {
        $this->authorizeEmployerJob($job);

        $job->publish();

        return back()->with('success', 'Job post published successfully.');
    }

    public function unpublish(JobPost $job): RedirectResponse
    {
        $this->authorizeEmployerJob($job);

        $job->unpublish();

        return back()->with('success', 'Job post moved back to draft.');
    }

    public function close(JobPost $job): RedirectResponse
    {
        $this->authorizeEmployerJob($job);

        $job->close();

        return back()->with('success', 'Job post closed successfully.');
    }

    private function validateJob(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'workplace_type' => ['required', 'in:remote,on_site,hybrid'],
            'job_type' => ['required', 'in:full_time,part_time,contract'],
            'salary_currency' => ['required', 'string', 'max:10'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'skills_required' => ['nullable', 'string', 'max:3000'],
            'description' => ['required', 'string', 'max:20000'],
            'status' => ['required', 'in:draft,published,closed'],
            'application_deadline' => ['nullable', 'date', 'after_or_equal:today'],
        ]);
    }

    private function authorizeEmployerJob(JobPost $job): void
    {
        abort_unless($job->user_id === auth()->id(), 403);
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            JobPost::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}