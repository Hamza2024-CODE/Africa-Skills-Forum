<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->string('document_type'); // identity, passport, consent, medical, organization, other
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');

            $table->string('status')->default('UPLOADED'); // MISSING, UPLOADED, UNDER_REVIEW, APPROVED, REJECTED, EXPIRED
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participant_documents');
    }
};
