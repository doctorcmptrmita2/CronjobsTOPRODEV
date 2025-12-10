<?php

namespace App\Console\Commands;

use App\Jobs\RunJob;
use App\Models\Job;
use Illuminate\Console\Command;

class DispatchDueJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cronjobs:dispatch-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch due jobs to the queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $staleLock = $now->copy()->subMinutes(5);

        Job::query()
            ->where('is_active', true)
            ->whereNotNull('next_run_at')
            ->where('next_run_at', '<=', $now)
            ->where(function ($query) use ($staleLock) {
                $query->whereNull('locked_at')
                    ->orWhere('locked_at', '<', $staleLock);
            })
            ->orderBy('next_run_at')
            ->chunkById(50, function ($jobs) use ($now, $staleLock) {
                foreach ($jobs as $job) {
                    $locked = Job::whereKey($job->id)
                        ->where(function ($query) use ($staleLock) {
                            $query->whereNull('locked_at')
                                ->orWhere('locked_at', '<', $staleLock);
                        })
                        ->update(['locked_at' => $now]);

                    if ($locked) {
                        RunJob::dispatch($job->id);
                        $this->info("Queued job #{$job->id} ({$job->name})");
                    }
                }
            });

        return Command::SUCCESS;
    }
}
