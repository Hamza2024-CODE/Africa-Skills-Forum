<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('equipment_categories')->onDelete('set null');
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en')->nullable();
            $table->string('item_type'); // ppe, clothing, tool, machine, consumable, workstation
            $table->text('specification_details')->nullable();
            $table->string('safety_level')->default('standard');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_items');
    }
};
