<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Services\JobSchedulerService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $defaultPlanId = Plan::where('slug', 'free')->value('id');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'timezone' => 'UTC',
            'notification_email' => $request->email,
            'plan_id' => $defaultPlanId,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Check for pending job from landing page
        if (session()->has('pending_job')) {
            return $this->createPendingJob($user);
        }

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Create the pending job for the newly registered user.
     */
    protected function createPendingJob(User $user): RedirectResponse
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
            ->with('success', '🎉 Welcome! Your job has been created and is now being monitored!');
    }
}
