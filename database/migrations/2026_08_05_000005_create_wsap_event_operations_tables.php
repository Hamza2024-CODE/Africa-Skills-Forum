<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('wsap_schedule_reminders');
        Schema::dropIfExists('wsap_schedule_targets');
        Schema::dropIfExists('wsap_schedule_events');
        Schema::dropIfExists('badge_zone_permissions');
        Schema::dropIfExists('wsap_zones');

        // 1. wsap_zones table
        Schema::create('wsap_zones', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ZONE-A, ZONE-B, ZONE-C
            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. badge_zone_permissions table (Time-bounded Zone Access)
        Schema::create('badge_zone_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badge_id')->constrained('badges')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('wsap_zones')->onDelete('cascade');
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->string('permission')->default('ALLOW'); // ALLOW, DENY
            $table->timestamps();

            $table->index(['badge_id', 'zone_id']);
        });

        // 3. wsap_schedule_events table (Polymorphic Orchestration)
        Schema::create('wsap_schedule_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('event_type'); // TECHNICAL_MEETING, COMPETITION_ROUND, MEAL_SLOT, TRANSPORT, ACCOMMODATION, CEREMONY, DELEGATION_MEETING
            
            // Polymorphic orchestration link
            $table->string('source_type')->nullable(); // e.g. App\Models\MealSlot, App\Models\Skill
            $table->string('source_id')->nullable();

            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('location_name')->nullable();

            $table->foreignId('zone_id')->nullable()->constrained('wsap_zones')->onDelete('set null');
            $table->foreignId('skill_id')->nullable()->constrained('skills')->onDelete('set null');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            // Lifecycle: DRAFT, SCHEDULED, OPEN, IN_PROGRESS, COMPLETED, CANCELLED, POSTPONED, ARCHIVED
            $table->string('status')->default('SCHEDULED');

            $table->integer('reminder_offset_minutes')->default(30);
            $table->boolean('auto_notify')->default(true);

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['event_type', 'status']);
            $table->index(['start_at', 'end_at']);
        });

        // 4. wsap_schedule_targets table (Deterministic Recipient Snapshot)
        Schema::create('wsap_schedule_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('wsap_schedule_events')->onDelete('cascade');
            $table->string('target_type'); // role, country, skill, meal_slot, individual_user
            $table->string('target_id');
            $table->timestamps();

            $table->index(['event_id', 'target_type']);
        });

        // 5. wsap_schedule_reminders table (Idempotent Reminder Log)
        Schema::create('wsap_schedule_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('wsap_schedule_events')->onDelete('cascade');
            $table->string('idempotency_key')->unique(); // event:{uuid}:reminder:{offset}
            $table->integer('offset_minutes');
            $table->dateTime('dispatched_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsap_schedule_reminders');
        Schema::dropIfExists('wsap_schedule_targets');
        Schema::dropIfExists('wsap_schedule_events');
        Schema::dropIfExists('badge_zone_permissions');
        Schema::dropIfExists('wsap_zones');
    }
};
