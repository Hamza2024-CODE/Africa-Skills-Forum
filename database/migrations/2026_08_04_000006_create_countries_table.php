<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('iso2', 2)->unique();
            $table->string('iso3', 3)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('nationality_ar')->nullable();
            $table->string('nationality_fr')->nullable();
            $table->string('nationality_en')->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('flag')->nullable();
            $table->boolean('is_african')->default(true);
            $table->boolean('is_algeria')->default(false);
            $table->boolean('requires_passport')->default(true);
            $table->boolean('requires_national_id')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
