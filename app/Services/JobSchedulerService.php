<?php

namespace App\Services;

use App\Models\Job;
use Carbon\Carbon;
use Cron\CronExpression;

class JobSchedulerService
{
    public function calculateNextRun(Job $job, ?Carbon $from = null): ?Carbon
    {
        $reference = $from ? $from->copy() : now();
        $tz = $job->timezone ?: 'UTC';
        $localNow = $reference->copy()->setTimezone($tz);

        $next = match ($job->schedule_type) {
            'interval' => $this->nextInterval($job, $localNow),
            'daily' => $this->nextDaily($job, $localNow),
            'weekly' => $this->nextWeekly($job, $localNow),
            'cron' => $this->nextCron($job, $localNow),
            default => null,
        };

        return $next ? $next->utc() : null;
    }

    protected function nextInterval(Job $job, Carbon $from): ?Carbon
    {
        if (!$job->interval_minutes) {
            return null;
        }

        return $from->copy()->addMinutes($job->interval_minutes);
    }

    protected function nextDaily(Job $job, Carbon $from): ?Carbon
    {
        if (!$job->daily_time) {
            return null;
        }

        $next = Carbon::parse($job->daily_time, $job->timezone ?: 'UTC')->setDate(
            $from->year,
            $from->month,
            $from->day
        );

        if ($next->lessThanOrEqualTo($from)) {
            $next->addDay();
        }

        return $next;
    }

    protected function nextWeekly(Job $job, Carbon $from): ?Carbon
    {
        if ($job->weekly_day_of_week === null || !$job->daily_time) {
            return null;
        }

        $next = Carbon::parse($job->daily_time, $job->timezone ?: 'UTC')->setDate(
            $from->year,
            $from->month,
            $from->day
        );

        while ($next->dayOfWeek !== (int) $job->weekly_day_of_week || $next->lessThanOrEqualTo($from)) {
            $next->addDay();
        }

        return $next;
    }

    protected function nextCron(Job $job, Carbon $from): ?Carbon
    {
        if (!$job->cron_expression) {
            return null;
        }

        try {
            $expression = CronExpression::factory($job->cron_expression);

            return Carbon::instance($expression->getNextRunDate($from));
        } catch (\Throwable) {
            return null;
        }
    }
}
