<?php

namespace App\Console\Commands;

use App\Models\Check;
use App\Services\CheckRunnerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunDueChecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checks:run 
                            {--limit=100 : Maximum number of checks to run in this batch}
                            {--force : Run all active checks regardless of schedule}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all due uptime checks';

    public function __construct(
        protected CheckRunnerService $runnerService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        $force = $this->option('force');

        $query = Check::where('is_active', true)
            ->whereNull('locked_at');

        if (!$force) {
            $query->where(function ($q) {
                $q->whereNull('last_checked_at')
                    ->orWhereRaw('last_checked_at <= NOW() - INTERVAL interval_seconds SECOND');
            });
        }

        $checks = $query->orderBy('last_checked_at', 'asc')
            ->limit($limit)
            ->get();

        if ($checks->isEmpty()) {
            $this->info('No checks due to run.');
            return self::SUCCESS;
        }

        $this->info("Running {$checks->count()} checks...");

        $success = 0;
        $failed = 0;

        foreach ($checks as $check) {
            // Lock the check to prevent concurrent execution
            $check->update(['locked_at' => now()]);

            try {
                $result = $this->runnerService->runAndRecord($check);
                
                if ($result->is_up) {
                    $success++;
                    $this->line("  ✓ {$check->name} - {$result->response_time_ms}ms");
                } else {
                    $failed++;
                    $this->warn("  ✗ {$check->name} - {$result->error_message}");
                }
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ {$check->name} - Error: {$e->getMessage()}");
                Log::error("Check {$check->id} failed with exception: " . $e->getMessage());
                
                // Make sure to unlock even on error
                $check->update(['locked_at' => null]);
            }
        }

        $this->newLine();
        $this->info("Completed: {$success} up, {$failed} down");

        return self::SUCCESS;
    }
}






