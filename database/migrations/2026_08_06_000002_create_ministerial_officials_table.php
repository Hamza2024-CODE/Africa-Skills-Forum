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
        if (!Schema::hasTable('ministerial_officials')) {
            Schema::create('ministerial_officials', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->unique();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
                $table->string('full_name');
                $table->string('title_ar')->nullable();
                $table->string('title_fr')->nullable();
                $table->string('title_en')->nullable();
                $table->string('ministry_name')->nullable();
                $table->string('availability_status')->default('AVAILABLE');
                $table->string('contact_phone')->nullable();
                $table->string('security_level')->default('VIP');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministerial_officials');
    }
};
