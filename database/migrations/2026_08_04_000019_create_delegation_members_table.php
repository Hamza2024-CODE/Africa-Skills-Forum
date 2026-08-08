<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delegation_members', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('delegation_id')->constrained('country_delegations')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('member_type'); // PARTICIPANT, EXPERT, JUDGE, DELEGATE, OFFICIAL, SUPPORT_STAFF
            $table->string('first_name');
            $table->string('last_name');
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->string('gender', 10)->default('male');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('arrival_flight')->nullable();
            $table->string('departure_flight')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delegation_members');
    }
};
