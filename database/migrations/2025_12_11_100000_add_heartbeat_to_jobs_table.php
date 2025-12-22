<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Adds heartbeat monitoring support to jobs table.
     * - type: 'cron' (default) or 'heartbeat'
     * - heartbeat_token: unique token for ping endpoint
     * - heartbeat_interval: expected ping interval in minutes
     * - last_ping_at: timestamp of last received ping
     */
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Job type: cron (we call them) or heartbeat (they call us)
            $table->enum('type', ['cron', 'heartbeat'])->default('cron')->after('user_id');
            
            // Unique token for heartbeat ping endpoint
            $table->string('heartbeat_token', 64)->nullable()->unique()->after('type');
            
            // Expected interval between pings (in minutes)
            $table->unsignedInteger('heartbeat_interval')->nullable()->after('heartbeat_token');
            
            // Last ping received timestamp
            $table->timestamp('last_ping_at')->nullable()->after('heartbeat_interval');
            
            // Grace period before alerting (in minutes, default: interval * 1.5)
            $table->unsignedInteger('heartbeat_grace')->nullable()->after('last_ping_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'heartbeat_token',
                'heartbeat_interval',
                'last_ping_at',
                'heartbeat_grace'
            ]);
        });
    }
};







