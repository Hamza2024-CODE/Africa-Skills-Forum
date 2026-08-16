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
        if (!Schema::hasTable('diplomatic_meeting_rooms')) {
            Schema::create('diplomatic_meeting_rooms', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->string('name_ar');
                $table->string('name_fr')->nullable();
                $table->string('name_en')->nullable();
                $table->integer('capacity')->default(10);
                $table->string('location_zone')->default('VIP Lounge');
                $table->string('status')->default('AVAILABLE');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('diplomatic_meetings')) {
            Schema::create('diplomatic_meetings', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->foreignId('host_minister_id')->nullable()->constrained('ministerial_officials')->nullOnDelete();
                $table->foreignId('guest_minister_id')->nullable()->constrained('ministerial_officials')->nullOnDelete();
                $table->foreignId('room_id')->nullable()->constrained('diplomatic_meeting_rooms')->nullOnDelete();
                $table->string('title');
                $table->text('purpose')->nullable();
                $table->dateTime('start_time')->nullable();
                $table->dateTime('end_time')->nullable();
                $table->string('status')->default('SCHEDULED');
                $table->text('notes')->nullable();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diplomatic_meetings');
        Schema::dropIfExists('diplomatic_meeting_rooms');
    }
};
