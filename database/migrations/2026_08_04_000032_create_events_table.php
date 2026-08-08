<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('edition_id')->nullable()->constrained('editions')->nullOnDelete();
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->string('slug')->unique();

            $table->text('summary_ar')->nullable();
            $table->text('summary_fr')->nullable();
            $table->text('summary_en')->nullable();

            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();

            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->string('venue')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('wilaya_id')->nullable()->constrained('wilayas')->nullOnDelete();

            $table->foreignId('cover_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('status')->default('PUBLISHED'); // UPCOMING, LIVE, ENDED, PUBLISHED
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });

        Schema::create('event_schedule_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('title_ar');
            $table->string('title_fr')->nullable();
            $table->string('title_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->string('start_time');
            $table->string('end_time')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_schedule_items');
        Schema::dropIfExists('events');
    }
};
