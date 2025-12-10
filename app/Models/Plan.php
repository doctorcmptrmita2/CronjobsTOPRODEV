<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'max_jobs',
        'min_interval_minutes',
        'log_retention_days',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
