<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobBoardController extends Controller
{
    public function index(Request $request): View
    {
        $jobs = JobPost::query()
            ->with('employer.employerProfile')
            ->published()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%")
                        ->orWhere('skills_required', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('location'), function ($query) use ($request) {
                $location = $request->string('location')->toString();

                $query->where('location', 'like', "%{$location}%");
            })
            ->when($request->filled('workplace_type'), function ($query) use ($request) {
                $query->where('workplace_type', $request->string('workplace_type')->toString());
            })
            ->when($request->filled('job_type'), function ($query) use ($request) {
                $query->where('job_type', $request->string('job_type')->toString());
            })
            ->latest('published_at')
            ->paginate(10)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function show(JobPost $job): View
    {
        abort_unless($job->isPublished(), 404);

        if ($job->isExpired()) {
            abort(404);
        }

        $job->load('employer.employerProfile');

        return view('jobs.show', compact('job'));
    }
}