<?php

namespace App\Http\Controllers;

use App\Models\JobRun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $period = $request->get('period', '7d');
        
        // Determine date range
        $startDate = match($period) {
            '24h' => now()->subDay(),
            '7d' => now()->subDays(7),
            '30d' => now()->subDays(30),
            '90d' => now()->subDays(90),
            default => now()->subDays(7),
        };

        $jobIds = $user->jobs()->pluck('id');

        // Overall stats
        $totalRuns = JobRun::whereIn('job_id', $jobIds)
            ->where('ran_at', '>=', $startDate)
            ->count();

        $successfulRuns = JobRun::whereIn('job_id', $jobIds)
            ->where('ran_at', '>=', $startDate)
            ->where('success', true)
            ->count();

        $failedRuns = $totalRuns - $successfulRuns;
        $successRate = $totalRuns > 0 ? round(($successfulRuns / $totalRuns) * 100, 1) : 0;

        // Average response time
        $avgResponseTime = JobRun::whereIn('job_id', $jobIds)
            ->where('ran_at', '>=', $startDate)
            ->whereNotNull('duration_ms')
            ->avg('duration_ms') ?? 0;

        // Daily breakdown for chart
        $dailyStats = JobRun::whereIn('job_id', $jobIds)
            ->where('ran_at', '>=', $startDate)
            ->selectRaw('DATE(ran_at) as date, COUNT(*) as total, SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) as successful')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Per-job stats
        $jobStats = $user->jobs()
            ->withCount(['runs as total_runs' => function ($query) use ($startDate) {
                $query->where('ran_at', '>=', $startDate);
            }])
            ->withCount(['runs as successful_runs' => function ($query) use ($startDate) {
                $query->where('ran_at', '>=', $startDate)->where('success', true);
            }])
            ->withAvg(['runs as avg_duration' => function ($query) use ($startDate) {
                $query->where('ran_at', '>=', $startDate);
            }], 'duration_ms')
            ->get();

        // Status code distribution
        $statusCodes = JobRun::whereIn('job_id', $jobIds)
            ->where('ran_at', '>=', $startDate)
            ->whereNotNull('status_code')
            ->selectRaw('status_code, COUNT(*) as count')
            ->groupBy('status_code')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return view('statistics.index', [
            'period' => $period,
            'totalRuns' => $totalRuns,
            'successfulRuns' => $successfulRuns,
            'failedRuns' => $failedRuns,
            'successRate' => $successRate,
            'avgResponseTime' => round($avgResponseTime),
            'dailyStats' => $dailyStats,
            'jobStats' => $jobStats,
            'statusCodes' => $statusCodes,
        ]);
    }
}

