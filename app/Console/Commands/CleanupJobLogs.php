<?php

namespace App\Console\Commands;

use App\Models\JobRun;
use App\Models\Plan;
use Illuminate\Console\Command;

class CleanupJobLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjobs:cleanup-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old job run logs based on plan retention';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $defaultRetention = 30;

        foreach (Plan::all() as $plan) {
            $threshold = $now->copy()->subDays($plan->log_retention_days);

            $deleted = JobRun::whereHas('job.user', function ($query) use ($plan) {
                $query->where('plan_id', $plan->id);
            })
                ->where('ran_at', '<', $threshold)
                ->delete();

            if ($deleted) {
                $this->info("Deleted {$deleted} logs for plan {$plan->slug}");
            }
        }

        $fallbackDeleted = JobRun::whereHas('job.user', function ($query) {
            $query->whereNull('plan_id');
        })
            ->where('ran_at', '<', $now->copy()->subDays($defaultRetention))
            ->delete();

        if ($fallbackDeleted) {
            $this->info("Deleted {$fallbackDeleted} logs for users without plan");
        }

        return Command::SUCCESS;
    }
}
