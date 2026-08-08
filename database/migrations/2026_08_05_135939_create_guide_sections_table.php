<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // overview, structure, skills, ...
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            // Icon SVG path data (the d="..." value only)
            $table->text('icon_svg')->nullable();

            // Title — 3 languages
            $table->string('title_ar');
            $table->string('title_fr');
            $table->string('title_en');

            // Body — 3 languages (rich text / long text)
            $table->longText('body_ar')->nullable();
            $table->longText('body_fr')->nullable();
            $table->longText('body_en')->nullable();

            // Extra structured data stored as JSON (sub-items, lists, etc.)
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_sections');
    }
};
