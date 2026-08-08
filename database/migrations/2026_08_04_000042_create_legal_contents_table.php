<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_contents', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // privacy, terms, cookies, legal_notice
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->longText('content_ar');
            $table->longText('content_fr')->nullable();
            $table->longText('content_en')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('version')->default('1.0');
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_contents');
    }
};
