<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('skill_equipment')) {
            Schema::create('skill_equipment', function (Blueprint $table) {
                $table->id();
                $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
                $table->foreignId('equipment_item_id')->constrained('equipment_items')->onDelete('cascade');
                $table->boolean('is_required')->default(true);
                $table->integer('quantity')->default(1);
                $table->string('provided_by')->default('ORGANIZER'); // ORGANIZER, COUNTRY, PARTICIPANT, SPONSOR
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_equipment');
    }
};
