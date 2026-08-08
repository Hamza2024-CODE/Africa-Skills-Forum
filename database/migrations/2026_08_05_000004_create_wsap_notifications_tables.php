<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. wsap_notifications table
        Schema::create('wsap_notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type')->default('GENERAL'); // GENERAL, TECHNICAL_MEETING, MEAL, ACCOMMODATION, COMPETITION, SCHEDULE, URGENT, ANNOUNCEMENT
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('body_ar');
            $table->text('body_fr')->nullable();
            $table->text('body_en')->nullable();

            $table->string('priority')->default('NORMAL'); // LOW, NORMAL, HIGH, URGENT
            $table->string('status')->default('DRAFT'); // DRAFT, SCHEDULED, PROCESSING, SENT, CANCELLED, EXPIRED, FAILED

            $table->string('action_type')->nullable(); // MEAL_SLOT, TECHNICAL_MEETING, ACCOMMODATION, COMPETITION, SCHEDULE, NOTIFICATION_CENTER
            $table->string('action_id')->nullable();

            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 2. notification_targets table
        Schema::create('notification_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('wsap_notifications')->onDelete('cascade');
            $table->string('target_type'); // role, delegation, skill, meal_slot, individual_user
            $table->string('target_id'); // role_name, country_id, skill_id, slot_id, user_id
            $table->timestamps();

            $table->index(['notification_id', 'target_type']);
        });

        // 3. user_notifications table (Snapshot & Delivery tracking)
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('wsap_notifications')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('channel')->default('IN_APP'); // IN_APP, PWA_PUSH, EMAIL
            $table->string('status')->default('PENDING'); // PENDING, DELIVERED, READ, CLICKED, FAILED
            
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('clicked_at')->nullable();

            $table->timestamps();

            // Idempotency: Prevent duplicate delivery of same notification to same user on same channel
            $table->unique(['notification_id', 'user_id', 'channel']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('notification_targets');
        Schema::dropIfExists('wsap_notifications');
    }
};
