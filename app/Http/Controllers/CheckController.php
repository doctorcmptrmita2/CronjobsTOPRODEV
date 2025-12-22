<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\CheckRun;
use App\Services\CheckRunnerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{
    public function __construct(
        protected CheckRunnerService $runnerService
    ) {}

    /**
     * Display a listing of checks (Uptime Dashboard)
     */
    public function index(Request $request)
    {
        $checks = $request->user()
            ->checks()
            ->withCount(['runs as total_runs' => function ($query) {
                $query->where('checked_at', '>=', now()->subDay());
            }])
            ->latest()
            ->get();

        // Calculate stats
        $totalChecks = $checks->count();
        $checksUp = $checks->where('is_up', true)->where('is_active', true)->count();
        $checksDown = $checks->where('is_up', false)->where('is_active', true)->count();
        $avgUptime = $checks->where('is_active', true)->avg('uptime_percentage') ?? 100;

        return view('uptime.index', compact('checks', 'totalChecks', 'checksUp', 'checksDown', 'avgUptime'));
    }

    /**
     * Show the form for creating a new check
     */
    public function create()
    {
        $check = new Check();
        
        return view('uptime.create', compact('check'));
    }

    /**
     * Store a newly created check
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'http_method' => 'required|in:GET,HEAD,POST',
            'interval_seconds' => 'required|integer|in:30,60,120,300',
            'timeout_seconds' => 'required|integer|min:5|max:60',
            'expected_status_from' => 'required|integer|min:100|max:599',
            'expected_status_to' => 'required|integer|min:100|max:599|gte:expected_status_from',
            'keyword' => 'nullable|string|max:255',
            'keyword_should_exist' => 'boolean',
            'headers' => 'nullable|array',
            'headers.*.key' => 'nullable|string|max:255',
            'headers.*.value' => 'nullable|string|max:1024',
            'body' => 'nullable|string|max:10000',
            'is_active' => 'boolean',
            'alert_email_enabled' => 'boolean',
            'alert_threshold' => 'required|integer|min:1|max:10',
        ]);

        // Prepare headers JSON
        $headers = [];
        if (!empty($validated['headers'])) {
            foreach ($validated['headers'] as $header) {
                if (!empty($header['key']) && !empty($header['value'])) {
                    $headers[$header['key']] = $header['value'];
                }
            }
        }

        $check = $request->user()->checks()->create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'http_method' => $validated['http_method'],
            'interval_seconds' => $validated['interval_seconds'],
            'timeout_seconds' => $validated['timeout_seconds'],
            'expected_status_from' => $validated['expected_status_from'],
            'expected_status_to' => $validated['expected_status_to'],
            'keyword' => $validated['keyword'] ?? null,
            'keyword_should_exist' => $validated['keyword_should_exist'] ?? true,
            'headers_json' => !empty($headers) ? $headers : null,
            'body' => $validated['body'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'alert_email_enabled' => $validated['alert_email_enabled'] ?? true,
            'alert_threshold' => $validated['alert_threshold'],
        ]);

        // Run initial check
        $this->runnerService->runAndRecord($check);

        return redirect()->route('uptime.show', $check)
            ->with('success', 'Uptime check created and first check completed!');
    }

    /**
     * Display the specified check
     */
    public function show(Check $check)
    {
        $this->ensureOwnership($check);

        // Get recent runs for chart
        $recentRuns = $check->runs()
            ->orderByDesc('checked_at')
            ->limit(100)
            ->get()
            ->reverse()
            ->values();

        // Get stats for different periods
        $stats = [
            '1h' => $this->getStatsForPeriod($check, 1),
            '24h' => $this->getStatsForPeriod($check, 24),
            '7d' => $this->getStatsForPeriod($check, 24 * 7),
            '30d' => $this->getStatsForPeriod($check, 24 * 30),
        ];

        // Get incidents (downtime periods)
        $incidents = $this->getIncidents($check, 30);

        return view('uptime.show', compact('check', 'recentRuns', 'stats', 'incidents'));
    }

    /**
     * Show the form for editing the specified check
     */
    public function edit(Check $check)
    {
        $this->ensureOwnership($check);

        return view('uptime.edit', compact('check'));
    }

    /**
     * Update the specified check
     */
    public function update(Request $request, Check $check)
    {
        $this->ensureOwnership($check);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'http_method' => 'required|in:GET,HEAD,POST',
            'interval_seconds' => 'required|integer|in:30,60,120,300',
            'timeout_seconds' => 'required|integer|min:5|max:60',
            'expected_status_from' => 'required|integer|min:100|max:599',
            'expected_status_to' => 'required|integer|min:100|max:599|gte:expected_status_from',
            'keyword' => 'nullable|string|max:255',
            'keyword_should_exist' => 'boolean',
            'headers' => 'nullable|array',
            'headers.*.key' => 'nullable|string|max:255',
            'headers.*.value' => 'nullable|string|max:1024',
            'body' => 'nullable|string|max:10000',
            'is_active' => 'boolean',
            'alert_email_enabled' => 'boolean',
            'alert_threshold' => 'required|integer|min:1|max:10',
        ]);

        // Prepare headers JSON
        $headers = [];
        if (!empty($validated['headers'])) {
            foreach ($validated['headers'] as $header) {
                if (!empty($header['key']) && !empty($header['value'])) {
                    $headers[$header['key']] = $header['value'];
                }
            }
        }

        $check->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'http_method' => $validated['http_method'],
            'interval_seconds' => $validated['interval_seconds'],
            'timeout_seconds' => $validated['timeout_seconds'],
            'expected_status_from' => $validated['expected_status_from'],
            'expected_status_to' => $validated['expected_status_to'],
            'keyword' => $validated['keyword'] ?? null,
            'keyword_should_exist' => $validated['keyword_should_exist'] ?? true,
            'headers_json' => !empty($headers) ? $headers : null,
            'body' => $validated['body'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
            'alert_email_enabled' => $validated['alert_email_enabled'] ?? true,
            'alert_threshold' => $validated['alert_threshold'],
        ]);

        return redirect()->route('uptime.show', $check)
            ->with('success', 'Check updated successfully.');
    }

    /**
     * Remove the specified check
     */
    public function destroy(Check $check)
    {
        $this->ensureOwnership($check);

        $check->delete();

        return redirect()->route('uptime.index')
            ->with('success', 'Check deleted successfully.');
    }

    /**
     * Toggle check active status
     */
    public function toggle(Check $check)
    {
        $this->ensureOwnership($check);

        $check->update(['is_active' => !$check->is_active]);

        return back()->with('success', 'Check ' . ($check->is_active ? 'activated' : 'paused') . '.');
    }

    /**
     * Run check now
     */
    public function runNow(Check $check)
    {
        $this->ensureOwnership($check);

        $this->runnerService->runAndRecord($check);

        return back()->with('success', 'Check executed successfully.');
    }

    /**
     * Ensure the authenticated user owns the check
     */
    protected function ensureOwnership(Check $check): void
    {
        if ($check->user_id !== auth()->id()) {
            abort(403);
        }
    }

    /**
     * Get stats for a time period
     */
    protected function getStatsForPeriod(Check $check, int $hours): array
    {
        $since = now()->subHours($hours);
        
        $runs = $check->runs()
            ->where('checked_at', '>=', $since)
            ->get();

        if ($runs->isEmpty()) {
            return [
                'uptime' => 100,
                'avg_response' => null,
                'total_checks' => 0,
                'incidents' => 0,
            ];
        }

        $upCount = $runs->where('is_up', true)->count();
        
        // Count incidents (transitions from up to down)
        $incidents = 0;
        $wasUp = true;
        foreach ($runs->sortBy('checked_at') as $run) {
            if (!$run->is_up && $wasUp) {
                $incidents++;
            }
            $wasUp = $run->is_up;
        }

        return [
            'uptime' => round(($upCount / $runs->count()) * 100, 2),
            'avg_response' => (int) round($runs->whereNotNull('response_time_ms')->avg('response_time_ms')),
            'total_checks' => $runs->count(),
            'incidents' => $incidents,
        ];
    }

    /**
     * Get incidents (downtime periods) for a check
     */
    protected function getIncidents(Check $check, int $days): array
    {
        $since = now()->subDays($days);
        
        $runs = $check->runs()
            ->where('checked_at', '>=', $since)
            ->orderBy('checked_at')
            ->get();

        $incidents = [];
        $currentIncident = null;

        foreach ($runs as $run) {
            if (!$run->is_up) {
                if (!$currentIncident) {
                    $currentIncident = [
                        'started_at' => $run->checked_at,
                        'ended_at' => null,
                        'error' => $run->error_message,
                        'checks_failed' => 1,
                    ];
                } else {
                    $currentIncident['checks_failed']++;
                }
            } else {
                if ($currentIncident) {
                    $currentIncident['ended_at'] = $run->checked_at;
                    $currentIncident['duration'] = $currentIncident['started_at']->diffForHumans($currentIncident['ended_at'], ['parts' => 2, 'short' => true]);
                    $incidents[] = $currentIncident;
                    $currentIncident = null;
                }
            }
        }

        // If still in an incident
        if ($currentIncident) {
            $currentIncident['ended_at'] = null;
            $currentIncident['duration'] = 'Ongoing';
            $incidents[] = $currentIncident;
        }

        return array_reverse($incidents);
    }
}






