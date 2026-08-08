<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();

            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();

            $table->string('video_type')->default('youtube'); // youtube, vimeo, url, hls
            $table->string('video_url');
            $table->string('embed_url')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->integer('duration')->nullable(); // seconds

            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();
            $table->foreignId('skill_id')->nullable()->constrained('skills')->nullOnDelete();

            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('PUBLISHED');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
