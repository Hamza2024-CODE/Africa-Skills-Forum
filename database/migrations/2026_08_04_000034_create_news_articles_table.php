<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();

            $table->text('excerpt_ar')->nullable();
            $table->text('excerpt_fr')->nullable();
            $table->text('excerpt_en')->nullable();

            $table->longText('content_ar');
            $table->longText('content_fr')->nullable();
            $table->longText('content_en')->nullable();

            $table->string('featured_image')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete();

            $table->string('category')->default('news'); // news, blog, success_story, announcement
            $table->string('status')->default('PUBLISHED'); // DRAFT, REVIEW, SCHEDULED, PUBLISHED, ARCHIVED
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};
