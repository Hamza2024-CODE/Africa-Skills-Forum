<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing temporary tables if any
        Schema::dropIfExists('wsap_offline_scans');
        Schema::dropIfExists('wsap_emergency_lockdowns');
        Schema::dropIfExists('wsap_access_decisions');
        Schema::dropIfExists('wsap_badge_replacements');

        // 1. wsap_access_decisions table (Real-time Access Decision Log)
        Schema::create('wsap_access_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('badge_id')->nullable()->constrained('badges')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('service_type'); // MEAL_SLOT, HOTEL, TRANSPORT, COMPETITION, MEETING, ZONE
            $table->string('service_id')->nullable();
            $table->string('location_name')->nullable();
            $table->foreignId('zone_id')->nullable()->constrained('wsap_zones')->onDelete('set null');
            
            $table->string('decision')->default('DENY'); // ALLOW, DENY
            $table->string('reason_code'); // ACCESS_GRANTED, BADGE_REVOKED, RESTAURANT_NOT_ASSIGNED, MEAL_ALREADY_CONSUMED, ANTI_PASSBACK, ZONE_DENIED, etc.
            $table->text('reason_message_ar')->nullable();
            
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_offline_sync')->default(false);
            $table->timestamp('scanned_at');
            $table->timestamps();

            $table->index(['service_type', 'decision']);
            $table->index(['badge_id', 'scanned_at']);
        });

        // 2. wsap_badge_replacements table (Badge Revocation & History)
        Schema::create('wsap_badge_replacements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_badge_id')->constrained('badges')->onDelete('cascade');
            $table->foreignId('replacement_badge_id')->nullable()->constrained('badges')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action_type'); // REVOKED, SUSPENDED, LOST, REPLACED
            $table->text('reason_ar');
            $table->foreignId('performed_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 3. wsap_emergency_lockdowns table (Emergency Control)
        Schema::create('wsap_emergency_lockdowns', function (Blueprint $table) {
            $table->id();
            $table->string('lockdown_scope'); // RESTAURANT, ZONE, COMPETITION_HALL, ALL_MEALS, ALL_TRANSPORT
            $table->string('target_id')->nullable(); // Zone ID, Restaurant ID, etc.
            $table->string('title_ar');
            $table->text('reason_ar');
            $table->boolean('is_active')->default(true);
            $table->foreignId('initiated_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('initiated_at');
            $table->timestamp('lifted_at')->nullable();
            $table->timestamps();
        });

        // 4. wsap_offline_scans table (Offline Sync Queue)
        Schema::create('wsap_offline_scans', function (Blueprint $table) {
            $table->id();
            $table->string('sync_uuid')->unique();
            $table->string('badge_token');
            $table->string('service_type');
            $table->string('service_id')->nullable();
            $table->foreignId('scanned_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('offline_scanned_at');
            $table->string('sync_status')->default('PENDING'); // PENDING, PROCESSED, DUPLICATE_SKIPPED
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wsap_offline_scans');
        Schema::dropIfExists('wsap_emergency_lockdowns');
        Schema::dropIfExists('wsap_badge_replacements');
        Schema::dropIfExists('wsap_access_decisions');
    }
};
