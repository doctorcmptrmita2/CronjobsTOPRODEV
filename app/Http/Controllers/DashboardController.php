<?php

namespace App\Http\Controllers;

use App\Models\JobRun;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $since = now()->subDay();

        $totalJobs = $user->jobs()->count();
        $activeJobs = $user->jobs()->where('is_active', true)->count();

        $runsQuery = JobRun::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('ran_at', '>=', $since);

        $runsLast24h = $runsQuery->count();
        $successCount = (clone $runsQuery)->where('success', true)->count();
        $successRate = $runsLast24h > 0 ? round(($successCount / $runsLast24h) * 100, 1) : 0;

        $recentRuns = JobRun::with('job')
            ->whereHas('job', fn ($query) => $query->where('user_id', $user->id))
            ->latest('ran_at')
            ->limit(10)
            ->get();

        return view('dashboard', [
            'totalJobs' => $totalJobs,
            'activeJobs' => $activeJobs,
            'runsLast24h' => $runsLast24h,
            'successRate' => $successRate,
            'recentRuns' => $recentRuns,
        ]);
    }
}
