<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('year')->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->boolean('is_active')->default(false);
            $table->string('status')->default('DRAFT');
            $table->json('theme_config')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('editions');
    }
};
