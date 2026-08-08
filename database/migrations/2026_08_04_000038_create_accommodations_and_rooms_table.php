<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();

            $table->string('address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->integer('total_capacity')->default(100);
            $table->string('status')->default('active');

            $table->timestamps();
        });

        Schema::create('accommodation_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accommodation_id')->constrained('accommodations')->cascadeOnDelete();
            $table->string('room_number');
            $table->integer('capacity')->default(2);
            $table->string('gender')->default('any'); // male, female, any
            $table->string('status')->default('AVAILABLE'); // AVAILABLE, OCCUPIED, MAINTENANCE
            $table->timestamps();
        });

        Schema::create('room_allocations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('room_id')->constrained('accommodation_rooms')->cascadeOnDelete();
            $table->foreignId('participant_profile_id')->nullable()->constrained('participant_profiles')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->timestamp('check_in_at')->nullable();
            $table->timestamp('check_out_at')->nullable();
            $table->string('status')->default('CONFIRMED');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_allocations');
        Schema::dropIfExists('accommodation_rooms');
        Schema::dropIfExists('accommodations');
    }
};
