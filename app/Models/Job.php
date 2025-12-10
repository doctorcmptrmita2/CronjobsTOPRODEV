<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'url',
        'http_method',
        'headers_json',
        'body',
        'timeout_seconds',
        'expected_status_from',
        'expected_status_to',
        'schedule_type',
        'interval_minutes',
        'daily_time',
        'weekly_day_of_week',
        'cron_expression',
        'timezone',
        'is_active',
        'max_retries',
        'failure_alert_threshold',
        'alert_email_enabled',
        'last_run_at',
        'next_run_at',
        'last_status_code',
        'last_duration_ms',
        'last_error_message',
        'consecutive_failures',
        'locked_at',
    ];

    protected $casts = [
        'headers_json' => 'array',
        'is_active' => 'boolean',
        'alert_email_enabled' => 'boolean',
        'last_run_at' => 'datetime',
        'next_run_at' => 'datetime',
        'locked_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function runs(): HasMany
    {
        return $this->hasMany(JobRun::class);
    }

    public function getScheduleSummaryAttribute(): string
    {
        return match ($this->schedule_type) {
            'interval' => "Every {$this->interval_minutes} min",
            'daily' => "Daily at {$this->daily_time}",
            'weekly' => "Weekly on " . Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays((int) $this->weekly_day_of_week)->format('D') . " at {$this->daily_time}",
            'cron' => $this->cron_expression,
            default => 'Not scheduled',
        };
    }

    public function preparedHeaders(): array
    {
        $headers = $this->headers_json ?? [];

        return collect($headers)
            ->filter(fn ($value, $key) => filled($key) && filled($value))
            ->mapWithKeys(fn ($value, $key) => [trim($key) => trim($value)])
            ->all();
    }
}
