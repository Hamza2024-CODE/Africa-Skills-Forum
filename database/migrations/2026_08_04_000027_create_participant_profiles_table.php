<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('participant_profiles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->string('first_name_ar');
            $table->string('last_name_ar');
            $table->string('first_name_fr')->nullable();
            $table->string('last_name_fr')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('last_name_en')->nullable();

            $table->string('gender')->default('male');
            $table->date('date_of_birth')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->string('national_id')->nullable()->index();
            $table->string('passport_number')->nullable()->index();
            $table->date('passport_expiry')->nullable();

            $table->foreignId('wilaya_id')->nullable()->constrained('wilayas')->nullOnDelete();
            $table->foreignId('commune_id')->nullable()->constrained('communes')->nullOnDelete();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->nullOnDelete();

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('participant_profiles');
        Schema::enableForeignKeyConstraints();
    }
};
