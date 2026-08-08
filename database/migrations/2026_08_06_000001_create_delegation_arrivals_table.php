<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delegation_arrivals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->date('arrival_date');
            $table->time('arrival_time');
            $table->string('airline_name');
            $table->string('flight_number');
            $table->string('arrival_airport');
            $table->integer('passenger_count')->default(1);
            $table->string('ticket_path')->nullable();
            $table->string('ticket_filename')->nullable();
            $table->string('ticket_type')->default('pdf');
            $table->text('notes')->nullable();
            $table->string('status')->default('PENDING'); // PENDING, APPROVED, CANCELLED
            $table->string('shuttle_assigned')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delegation_arrivals');
    }
};
