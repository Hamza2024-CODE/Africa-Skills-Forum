<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_clothing', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('participant_profile_id')->constrained('participant_profiles')->cascadeOnDelete();
            $table->string('item_name_ar');
            $table->string('item_name_fr')->nullable();
            $table->string('item_name_en')->nullable();

            $table->string('size'); // S, M, L, XL, XXL, 42, 43 etc.
            $table->integer('quantity')->default(1);
            $table->boolean('is_mandatory')->default(true);
            $table->string('provided_by')->default('ORGANIZER');

            $table->string('status')->default('PENDING'); // PENDING, PREPARED, DELIVERED, RECEIVED
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_clothing');
    }
};
