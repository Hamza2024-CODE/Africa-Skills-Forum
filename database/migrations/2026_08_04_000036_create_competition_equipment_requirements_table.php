<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('competition_equipment_requirements', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('skill_id')->constrained('skills')->cascadeOnDelete();
            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();

            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();

            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();

            $table->integer('quantity')->default(1);
            $table->string('unit')->default('pcs');
            $table->boolean('is_mandatory')->default(true);
            $table->boolean('is_ppe')->default(false);

            $table->string('provided_by')->default('ORGANIZER'); // ORGANIZER, COUNTRY, ORGANIZATION, PARTICIPANT, SPONSOR
            $table->text('technical_specifications')->nullable();
            $table->text('safety_notes')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });

        Schema::create('participant_equipment_checklists', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('participant_profile_id')->constrained('participant_profiles')->cascadeOnDelete();
            $table->foreignId('requirement_id')->constrained('competition_equipment_requirements')->cascadeOnDelete();

            $table->string('status')->default('PENDING'); // PENDING, PREPARED, DELIVERED, RECEIVED, MISSING, VERIFIED
            $table->text('notes')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_equipment_checklists');
        Schema::dropIfExists('competition_equipment_requirements');
    }
};
