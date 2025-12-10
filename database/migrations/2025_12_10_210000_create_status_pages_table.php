<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_public']);
        });

        Schema::create('status_page_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_page_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['status_page_id', 'job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_page_jobs');
        Schema::dropIfExists('status_pages');
    }
};

