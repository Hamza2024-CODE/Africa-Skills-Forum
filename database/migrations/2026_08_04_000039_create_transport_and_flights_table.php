<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name_ar');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();

            $table->string('origin');
            $table->string('destination');
            $table->integer('vehicle_capacity')->default(50);
            $table->string('status')->default('active');

            $table->timestamps();
        });

        Schema::create('transport_trips', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->timestamp('departure_at');
            $table->timestamp('arrival_at')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('driver_contact')->nullable();
            $table->integer('booked_passengers')->default(0);

            $table->timestamps();
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('flight_number');
            $table->string('airline');
            $table->string('type')->default('ARRIVAL'); // ARRIVAL, DEPARTURE
            $table->string('airport');
            $table->timestamp('scheduled_at');
            $table->integer('passengers_count')->default(1);
            $table->string('status')->default('CONFIRMED');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
        Schema::dropIfExists('transport_trips');
        Schema::dropIfExists('transport_routes');
    }
};
