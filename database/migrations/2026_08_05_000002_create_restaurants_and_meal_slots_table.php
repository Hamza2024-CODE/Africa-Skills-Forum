<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ======================================================
        // 1. RESTAURANTS — المطاعم
        // ======================================================
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->string('location')->nullable();        // الموقع (مبنى/قاعة)
            $table->string('contact_phone')->nullable();
            $table->unsignedInteger('capacity')->default(500);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();

            $table->timestamps();
        });

        // ======================================================
        // 2. MEAL SLOTS — خانات الوجبات اليومية لكل مطعم
        // ======================================================
        Schema::create('meal_slots', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('restaurant_id')->constrained('restaurants')->cascadeOnDelete();

            $table->date('date');
            $table->string('meal_type')->default('LUNCH'); // BREAKFAST, LUNCH, DINNER, SNACK
            $table->time('start_time');
            $table->time('end_time');

            $table->unsignedInteger('max_capacity')->default(500);

            $table->boolean('is_open')->default(true);
            $table->text('notes')->nullable();

            $table->timestamps();

            // Index for fast lookup by date + type
            $table->index(['date', 'meal_type']);
            $table->index(['restaurant_id', 'date']);
        });

        // ======================================================
        // 3. MEAL ENTITLEMENTS — استحقاقات الوجبات
        // استحقاق يُعطى لشخص أو وفد لوجبة معينة في مطعم معين
        // ======================================================
        Schema::create('meal_entitlements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('meal_slot_id')->constrained('meal_slots')->cascadeOnDelete();
            $table->foreignId('restaurant_id')->constrained('restaurants')->cascadeOnDelete();

            // Assigned to: user OR delegation (one of the two must be set)
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->string('status')->default('ACTIVE'); // ACTIVE, USED, CANCELLED, EXPIRED

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // A user can only have one entitlement per meal slot
            $table->unique(['meal_slot_id', 'user_id'], 'unique_user_slot');
        });

        // ======================================================
        // 4. MEAL SCANS — سجل مسح الشارات عند مدخل المطعم
        // Immutable Audit Log — لا يُحذف
        // ======================================================
        Schema::create('meal_scans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('meal_slot_id')->constrained('meal_slots')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('scanned_by_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('badge_code')->nullable();    // رمز الشارة الممسوح
            $table->string('status')->default('AUTHORIZED'); // AUTHORIZED, DENIED, DUPLICATE
            $table->string('denial_reason')->nullable();  // سبب الرفض

            // Snapshot of info at scan time (for audit integrity)
            $table->string('participant_name_snapshot')->nullable();
            $table->string('country_snapshot')->nullable();
            $table->string('restaurant_snapshot')->nullable();
            $table->string('meal_type_snapshot')->nullable();

            $table->timestamp('scanned_at')->useCurrent();
            $table->timestamps();

            // Fast lookup by slot + user (to detect duplicates)
            $table->index(['meal_slot_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_scans');
        Schema::dropIfExists('meal_entitlements');
        Schema::dropIfExists('meal_slots');
        Schema::dropIfExists('restaurants');
    }
};
