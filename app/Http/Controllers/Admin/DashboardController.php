<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobRun;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $since = now()->subDay();

        $stats = [
            'totalUsers' => User::count(),
            'totalJobs' => Job::count(),
            'activeJobs' => Job::where('is_active', true)->count(),
            'runsLast24h' => JobRun::where('ran_at', '>=', $since)->count(),
            'failedRunsLast24h' => JobRun::where('ran_at', '>=', $since)->where('success', false)->count(),
        ];

        $topFailing = Job::with('user')
            ->withCount([
                'runs as failures_count' => function ($query) use ($since) {
                    $query->where('success', false)->where('ran_at', '>=', $since);
                },
            ])
            ->whereHas('runs', fn ($query) => $query->where('success', false)->where('ran_at', '>=', $since))
            ->orderByDesc('failures_count')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'topFailing' => $topFailing,
        ]);
    }
}
