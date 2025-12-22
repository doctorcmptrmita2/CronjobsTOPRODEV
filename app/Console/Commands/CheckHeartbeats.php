<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\JobRun;
use App\Mail\JobFailedMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

/**
 * Checks for overdue heartbeat jobs and sends alerts.
 * 
 * Should be scheduled to run every minute.
 * 
 * Logic:
 * 1. Find all active heartbeat jobs
 * 2. Check if they're overdue (no ping within interval + grace)
 * 3. If overdue and not already alerted, create failure record and send alert
 */
class CheckHeartbeats extends Command
{
    protected $signature = 'heartbeats:check';

    protected $description = 'Check for overdue heartbeat jobs and send alerts';

    public function handle(): int
    {
        $this->info('Checking heartbeat jobs...');

        $heartbeatJobs = Job::where('type', Job::TYPE_HEARTBEAT)
            ->where('is_active', true)
            ->get();

        $checked = 0;
        $overdue = 0;
        $alerted = 0;

        foreach ($heartbeatJobs as $job) {
            $checked++;

            if ($job->isHeartbeatOverdue()) {
                $overdue++;

                // Check if we already recorded a failure recently (within last interval)
                // This prevents spamming alerts every minute
                $recentFailure = $job->runs()
                    ->where('status', 'failed')
                    ->where('created_at', '>=', now()->subMinutes($job->heartbeat_interval))
                    ->exists();

                if (!$recentFailure) {
                    $this->recordFailure($job);
                    $alerted++;
                    $this->warn("  ⚠ Job '{$job->name}' is overdue - alert sent");
                } else {
                    $this->line("  ⏳ Job '{$job->name}' is overdue (already alerted)");
                }
            } else {
                $this->line("  ✓ Job '{$job->name}' is healthy");
            }
        }

        $this->newLine();
        $this->info("Summary: {$checked} checked, {$overdue} overdue, {$alerted} newly alerted");

        return Command::SUCCESS;
    }

    /**
     * Record a failure for an overdue heartbeat job.
     */
    protected function recordFailure(Job $job): void
    {
        // Calculate how long it's been since last ping
        $lastPing = $job->last_ping_at ?? $job->created_at;
        $overdueMinutes = $lastPing->diffInMinutes(now());

        // Create a job run record to track the failure
        JobRun::create([
            'job_id' => $job->id,
            'status' => 'failed',
            'http_status_code' => null,
            'response_snippet' => "Heartbeat not received. Expected every {$job->heartbeat_interval} minutes. Last ping was {$overdueMinutes} minutes ago.",
            'duration_ms' => 0,
            'started_at' => now(),
            'finished_at' => now(),
            'attempt_number' => 1,
            'was_retry' => false,
            'error_message' => "Heartbeat missed: no ping received within expected interval ({$job->heartbeat_interval} min) + grace period ({$job->effective_grace} min)",
        ]);

        // Update job's consecutive failures
        $job->increment('consecutive_failures');
        $job->update([
            'last_error_message' => "Heartbeat missed at " . now()->format('Y-m-d H:i:s'),
        ]);

        // Send alert if enabled and threshold reached
        if ($job->alert_email_enabled && 
            $job->consecutive_failures >= $job->failure_alert_threshold) {
            $this->sendAlert($job);
        }
    }

    /**
     * Send alert email for missed heartbeat.
     */
    protected function sendAlert(Job $job): void
    {
        try {
            Mail::to($job->user->email)->queue(new JobFailedMail($job, $job->runs()->latest()->first()));
        } catch (\Exception $e) {
            $this->error("  Failed to send alert for job '{$job->name}': " . $e->getMessage());
        }
    }
}







