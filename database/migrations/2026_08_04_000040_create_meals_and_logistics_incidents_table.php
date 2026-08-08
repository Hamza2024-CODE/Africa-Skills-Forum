<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('participant_profile_id')->nullable()->constrained('participant_profiles')->cascadeOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('countries')->cascadeOnDelete();

            $table->date('date');
            $table->string('meal_type')->default('LUNCH'); // BREAKFAST, LUNCH, DINNER, SNACK
            $table->string('dietary_notes')->nullable();
            $table->boolean('is_served')->default(false);

            $table->timestamps();
        });

        Schema::create('logistics_incidents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('reference')->unique();
            $table->string('category')->default('EQUIPMENT_MISSING'); // EQUIPMENT_MISSING, TRANSPORT_DELAY, ROOM_ISSUE, OTHER
            $table->string('severity')->default('MEDIUM'); // LOW, MEDIUM, HIGH, CRITICAL
            $table->text('description');

            $table->foreignId('reported_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('status')->default('OPEN'); // OPEN, IN_PROGRESS, RESOLVED, CLOSED
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logistics_incidents');
        Schema::dropIfExists('meal_plans');
    }
};
