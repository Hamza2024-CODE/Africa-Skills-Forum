<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edition_countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('editions')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->boolean('is_registration_open')->default(true);
            $table->integer('max_participants')->default(500);
            $table->string('status')->default('ACTIVE');
            $table->timestamps();

            $table->unique(['edition_id', 'country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edition_countries');
    }
};
