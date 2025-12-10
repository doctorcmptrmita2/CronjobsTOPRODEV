<?php

namespace App\Jobs;

use App\Mail\JobFailureAlertMail;
use App\Models\Job;
use App\Models\JobRun;
use App\Services\JobRunnerService;
use App\Services\JobSchedulerService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class RunJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 1;

    public function __construct(public int $jobId)
    {
    }

    public function handle(JobRunnerService $runnerService, JobSchedulerService $schedulerService): void
    {
        $job = Job::with('user')->find($this->jobId);

        if (!$job || !$job->is_active) {
            if ($job) {
                $job->locked_at = null;
                $job->save();
            }

            return;
        }

        $now = now();
        $previousFailures = $job->consecutive_failures;

        $result = $runnerService->run($job);

        JobRun::create([
            'job_id' => $job->id,
            'ran_at' => $now,
            'status_code' => $result['status_code'],
            'duration_ms' => $result['duration_ms'],
            'success' => $result['success'],
            'error_message' => $result['error_message'],
            'response_snippet' => $result['response_snippet'],
        ]);

        $job->last_run_at = $now;
        $job->last_status_code = $result['status_code'];
        $job->last_duration_ms = $result['duration_ms'];
        $job->last_error_message = $result['error_message'];
        $job->consecutive_failures = $result['success'] ? 0 : $previousFailures + 1;
        $job->next_run_at = $schedulerService->calculateNextRun($job, $now);
        $job->locked_at = null;
        $job->save();

        if (!$result['success']) {
            $this->sendAlertIfNeeded($job, $previousFailures);
        }
    }

    protected function sendAlertIfNeeded(Job $job, int $previousFailures): void
    {
        if (! $job->alert_email_enabled) {
            return;
        }

        if ($job->consecutive_failures < $job->failure_alert_threshold) {
            return;
        }

        if ($previousFailures >= $job->failure_alert_threshold) {
            return;
        }

        $hadSuccessBefore = JobRun::where('job_id', $job->id)
            ->where('success', true)
            ->exists();

        if (! $hadSuccessBefore) {
            return;
        }

        $userEmail = $job->user->notification_email ?? $job->user->email;

        if ($userEmail) {
            Mail::to($userEmail)->queue(new JobFailureAlertMail($job));
        }
    }
}
