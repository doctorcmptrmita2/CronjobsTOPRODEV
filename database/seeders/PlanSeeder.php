<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(
            ['slug' => 'free'],
            [
                'name' => 'Free',
                'max_jobs' => 5,
                'min_interval_minutes' => 15,
                'log_retention_days' => 30,
            ]
        );

        Plan::updateOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'max_jobs' => 100,
                'min_interval_minutes' => 1,
                'log_retention_days' => 90,
            ]
        );
    }
}
