<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_delegations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('edition_id')->constrained('editions')->onDelete('cascade');
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('head_of_delegation_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('total_members_count')->default(0);
            $table->string('status')->default('ACTIVE');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['edition_id', 'country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('country_delegations');
    }
};
