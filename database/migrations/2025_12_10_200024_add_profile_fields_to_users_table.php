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
        Schema::table('users', function (Blueprint $table) {
            $table->string('timezone')->default('Europe/Istanbul')->after('email_verified_at');
            $table->string('notification_email')->nullable()->after('timezone');
            $table->foreignId('plan_id')->nullable()->constrained()->nullOnDelete()->after('notification_email');
            $table->boolean('is_admin')->default(false)->after('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn(['timezone', 'notification_email', 'plan_id', 'is_admin']);
        });
    }
};
