<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'ran_at',
        'status_code',
        'duration_ms',
        'success',
        'error_message',
        'response_snippet',
    ];

    protected $casts = [
        'ran_at' => 'datetime',
        'success' => 'boolean',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
