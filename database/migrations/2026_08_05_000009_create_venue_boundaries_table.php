<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('venue_boundaries');

        Schema::create('venue_boundaries', function (Blueprint $table) {
            $table->id('boundary_id');
            $table->foreignId('venue_map_id')->constrained('venue_maps', 'id')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->enum('boundary_type', ['COMPETITION', 'SECURITY', 'RESTRICTED', 'EMERGENCY', 'OPERATIONAL'])->default('COMPETITION');
            $table->enum('geometry_type', ['POLYGON', 'MULTIPOLYGON', 'LINESTRING'])->default('POLYGON');
            $table->json('geometry_json');
            $table->string('color_hex', 10)->default('#EAB308');
            $table->decimal('stroke_width', 4, 1)->default(4.0);
            $table->decimal('fill_opacity', 3, 2)->default(0.20);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('revision')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_boundaries');
    }
};
