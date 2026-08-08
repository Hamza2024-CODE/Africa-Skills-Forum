<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edition_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('editions')->onDelete('cascade');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->string('date_type');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->string('timezone')->default('Africa/Algiers');
            $table->string('location_ar')->nullable();
            $table->string('location_fr')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edition_dates');
    }
};
