<?php

namespace App\Http\Controllers;

use App\Services\JobRunnerService;
use App\Services\JobSchedulerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GuestJobController extends Controller
{
    /**
     * Store pending job and show preview dashboard.
     */
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:2048',
            'http_method' => 'required|in:GET,POST,PUT,PATCH,DELETE,HEAD',
            'timezone' => 'required|string|max:50',
            'cron_expression' => 'required|string|max:100',
        ]);

        // Generate a name from URL
        $urlParts = parse_url($validated['url']);
        $host = $urlParts['host'] ?? 'Unknown';
        $path = $urlParts['path'] ?? '/';
        $name = $host . ($path !== '/' ? $path : '');
        $name = substr($name, 0, 50);

        // Store in session
        $pendingJob = [
            'url' => $validated['url'],
            'http_method' => $validated['http_method'],
            'timezone' => $validated['timezone'],
            'cron_expression' => $validated['cron_expression'],
            'schedule_type' => 'cron',
            'name' => $name,
            'is_active' => true,
            'timeout_seconds' => 30,
            'max_retries' => 3,
            'expected_status_from' => 200,
            'expected_status_to' => 299,
            'alert_email_enabled' => true,
            'failure_alert_threshold' => 3,
            'test_run_used' => false,
            'test_result' => null,
        ];

        session(['pending_job' => $pendingJob]);

        return redirect()->route('guest.dashboard');
    }

    /**
     * Show guest preview dashboard.
     */
    public function dashboard()
    {
        $pendingJob = session('pending_job');

        if (!$pendingJob) {
            return redirect()->route('landing')
                ->with('error', 'Please create a job first.');
        }

        return view('guest.dashboard', [
            'job' => $pendingJob,
            'testResult' => $pendingJob['test_result'] ?? null,
            'testRunUsed' => $pendingJob['test_run_used'] ?? false,
        ]);
    }

    /**
     * Run a test for the pending job (limited to 1 per session).
     */
    public function testRun(Request $request)
    {
        $pendingJob = session('pending_job');

        if (!$pendingJob) {
            return redirect()->route('landing')
                ->with('error', 'Please create a job first.');
        }

        // Check if test already used
        if ($pendingJob['test_run_used']) {
            return redirect()->route('guest.dashboard')
                ->with('error', 'You have already used your free test run. Sign up to run more tests!');
        }

        // Perform the test run
        $start = microtime(true);
        $statusCode = null;
        $body = null;
        $errorMessage = null;

        try {
            $response = Http::timeout(10) // Short timeout for guest tests
                ->withoutVerifying() // Skip SSL verification for testing
                ->send($pendingJob['http_method'], $pendingJob['url']);

            $statusCode = $response->status();
            $body = $response->body();
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
        }

        $durationMs = (int) round((microtime(true) - $start) * 1000);

        $success = $statusCode !== null
            && $statusCode >= $pendingJob['expected_status_from']
            && $statusCode <= $pendingJob['expected_status_to'];

        // Store test result in session
        $pendingJob['test_run_used'] = true;
        $pendingJob['test_result'] = [
            'status_code' => $statusCode,
            'duration_ms' => $durationMs,
            'success' => $success,
            'error_message' => $errorMessage,
            'response_snippet' => $body ? mb_substr($body, 0, 500) : null,
            'ran_at' => now()->toIso8601String(),
        ];

        session(['pending_job' => $pendingJob]);

        return redirect()->route('guest.dashboard')
            ->with('success', 'Test run completed!');
    }

    /**
     * Redirect to register to save the job (or create immediately if logged in).
     */
    public function saveJob(JobSchedulerService $schedulerService)
    {
        $pendingJob = session('pending_job');

        if (!$pendingJob) {
            return redirect()->route('landing')
                ->with('error', 'Please create a job first.');
        }

        // If user is already logged in, create the job immediately
        if (auth()->check()) {
            $job = auth()->user()->jobs()->create([
                'name' => $pendingJob['name'] ?? 'My Job',
                'url' => $pendingJob['url'],
                'http_method' => $pendingJob['http_method'] ?? 'GET',
                'timezone' => $pendingJob['timezone'] ?? 'UTC',
                'cron_expression' => $pendingJob['cron_expression'],
                'schedule_type' => 'cron',
                'is_active' => true,
                'timeout_seconds' => $pendingJob['timeout_seconds'] ?? 30,
                'max_retries' => $pendingJob['max_retries'] ?? 3,
                'expected_status_from' => $pendingJob['expected_status_from'] ?? 200,
                'expected_status_to' => $pendingJob['expected_status_to'] ?? 299,
                'alert_email_enabled' => $pendingJob['alert_email_enabled'] ?? true,
                'failure_alert_threshold' => $pendingJob['failure_alert_threshold'] ?? 3,
            ]);

            $job->next_run_at = $schedulerService->calculateNextRun($job);
            $job->save();

            // Clear session
            session()->forget('pending_job');

            return redirect()->route('jobs.show', $job)
                ->with('success', '🎉 Your job has been created and is now being monitored!');
        }

        // Keep pending_job in session, redirect to register
        return redirect()->route('register')
            ->with('info', 'Create an account to save your job and start monitoring!');
    }
}

