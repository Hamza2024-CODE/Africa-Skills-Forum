<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_skill_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edition_id')->constrained('editions')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skills')->onDelete('cascade');
            $table->string('status')->default('DRAFT'); // DRAFT, REQUESTED, UNDER_REVIEW, APPROVED, REJECTED
            $table->foreignId('requested_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();

            $table->unique(['edition_id', 'country_id', 'skill_id'], 'country_skill_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_skill_selections');
    }
};
