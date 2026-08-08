<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique(); // e.g. SKILL-01, SKILL-39
            $table->foreignId('category_id')->nullable()->constrained('skill_categories')->onDelete('set null');
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('min_age')->default(16);
            $table->integer('max_age')->default(25);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
