<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PlanSeeder::class);

        $freePlanId = Plan::where('slug', 'free')->value('id');

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@cronjobs.to',
            'password' => Hash::make('password'),
            'timezone' => 'Europe/Istanbul',
            'notification_email' => 'admin@cronjobs.to',
            'plan_id' => $freePlanId,
            'is_admin' => true,
        ]);
    }
}
