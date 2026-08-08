<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();

            $table->string('logo_path')->nullable();
            $table->string('website_url')->nullable();

            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();

            $table->string('partner_type')->default('sponsor'); // organizer, official, sponsor, media, technical
            $table->string('level')->default('gold'); // platinum, gold, silver, bronze, partner
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
