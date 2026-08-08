<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();

            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();

            $table->foreignId('cover_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('PUBLISHED');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });

        Schema::create('album_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained('albums')->cascadeOnDelete();
            $table->foreignId('media_id')->constrained('media')->cascadeOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('album_media');
        Schema::dropIfExists('albums');
    }
};
