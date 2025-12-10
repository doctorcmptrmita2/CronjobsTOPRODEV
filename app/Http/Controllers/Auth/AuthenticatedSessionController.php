<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\JobSchedulerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check for pending job from landing page
        if (session()->has('pending_job')) {
            return $this->createPendingJob($request->user());
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Create the pending job for the logged in user.
     */
    protected function createPendingJob($user): RedirectResponse
    {
        $pendingData = session()->pull('pending_job');

        $job = $user->jobs()->create([
            'name' => $pendingData['name'] ?? 'My First Job',
            'url' => $pendingData['url'],
            'http_method' => $pendingData['http_method'] ?? 'GET',
            'timezone' => $pendingData['timezone'] ?? 'UTC',
            'cron_expression' => $pendingData['cron_expression'],
            'schedule_type' => 'cron',
            'is_active' => true,
            'timeout_seconds' => $pendingData['timeout_seconds'] ?? 30,
            'max_retries' => $pendingData['max_retries'] ?? 3,
            'expected_status_from' => $pendingData['expected_status_from'] ?? 200,
            'expected_status_to' => $pendingData['expected_status_to'] ?? 299,
            'alert_email_enabled' => $pendingData['alert_email_enabled'] ?? true,
            'failure_alert_threshold' => $pendingData['failure_alert_threshold'] ?? 3,
        ]);

        // Calculate next run
        $schedulerService = app(JobSchedulerService::class);
        $job->next_run_at = $schedulerService->calculateNextRun($job);
        $job->save();

        return redirect()->route('jobs.show', $job)
            ->with('success', '🎉 Welcome back! Your job has been created and is now being monitored!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
