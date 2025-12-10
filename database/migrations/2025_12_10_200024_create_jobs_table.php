<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('url');
            $table->string('http_method', 10);
            $table->json('headers_json')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedSmallInteger('timeout_seconds')->default(10);
            $table->unsignedSmallInteger('expected_status_from')->default(200);
            $table->unsignedSmallInteger('expected_status_to')->default(299);
            $table->string('schedule_type'); // interval | daily | weekly | cron
            $table->unsignedInteger('interval_minutes')->nullable();
            $table->time('daily_time')->nullable();
            $table->unsignedTinyInteger('weekly_day_of_week')->nullable();
            $table->string('cron_expression')->nullable();
            $table->string('timezone')->default('Europe/Istanbul');
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('max_retries')->default(3);
            $table->unsignedTinyInteger('failure_alert_threshold')->default(3);
            $table->boolean('alert_email_enabled')->default(true);
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('next_run_at')->nullable()->index();
            $table->smallInteger('last_status_code')->nullable();
            $table->unsignedInteger('last_duration_ms')->nullable();
            $table->string('last_error_message')->nullable();
            $table->unsignedInteger('consecutive_failures')->default(0);
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
