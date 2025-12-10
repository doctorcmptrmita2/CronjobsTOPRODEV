<?php

namespace App\Http\Controllers;

use App\Models\StatusPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatusPageController extends Controller
{
    public function index(Request $request)
    {
        $statusPages = $request->user()->statusPages()->latest()->get();
        
        return view('status-pages.index', compact('statusPages'));
    }

    public function create()
    {
        $jobs = auth()->user()->jobs()->where('is_active', true)->get();
        
        return view('status-pages.create', compact('jobs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:100|unique:status_pages,slug',
            'description' => 'nullable|string|max:500',
            'is_public' => 'boolean',
            'jobs' => 'array',
            'jobs.*' => 'exists:jobs,id',
        ]);

        $statusPage = $request->user()->statusPages()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'] ?? null,
            'is_public' => $validated['is_public'] ?? false,
        ]);

        if (!empty($validated['jobs'])) {
            $statusPage->jobs()->sync($validated['jobs']);
        }

        return redirect()->route('status-pages.index')
            ->with('success', 'Status page created successfully.');
    }

    public function edit(StatusPage $statusPage)
    {
        $this->authorize('update', $statusPage);
        
        $jobs = auth()->user()->jobs()->where('is_active', true)->get();
        $selectedJobs = $statusPage->jobs()->pluck('jobs.id')->toArray();
        
        return view('status-pages.edit', compact('statusPage', 'jobs', 'selectedJobs'));
    }

    public function update(Request $request, StatusPage $statusPage)
    {
        $this->authorize('update', $statusPage);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:100|unique:status_pages,slug,' . $statusPage->id,
            'description' => 'nullable|string|max:500',
            'is_public' => 'boolean',
            'jobs' => 'array',
            'jobs.*' => 'exists:jobs,id',
        ]);

        $statusPage->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'description' => $validated['description'] ?? null,
            'is_public' => $validated['is_public'] ?? false,
        ]);

        $statusPage->jobs()->sync($validated['jobs'] ?? []);

        return redirect()->route('status-pages.index')
            ->with('success', 'Status page updated successfully.');
    }

    public function destroy(StatusPage $statusPage)
    {
        $this->authorize('delete', $statusPage);
        
        $statusPage->delete();

        return redirect()->route('status-pages.index')
            ->with('success', 'Status page deleted.');
    }

    // Public view
    public function show(string $slug)
    {
        $statusPage = StatusPage::where('slug', $slug)
            ->where('is_public', true)
            ->firstOrFail();

        $jobs = $statusPage->jobs()
            ->with(['runs' => function ($query) {
                $query->latest('ran_at')->limit(50);
            }])
            ->get();

        // Calculate overall status
        $allOperational = $jobs->every(function ($job) {
            return $job->last_status_code >= 200 && $job->last_status_code < 300;
        });

        $someIssues = $jobs->contains(function ($job) {
            return $job->consecutive_failures > 0;
        });

        $overallStatus = $allOperational ? 'operational' : ($someIssues ? 'degraded' : 'outage');

        return view('status-pages.public', compact('statusPage', 'jobs', 'overallStatus'));
    }
}

