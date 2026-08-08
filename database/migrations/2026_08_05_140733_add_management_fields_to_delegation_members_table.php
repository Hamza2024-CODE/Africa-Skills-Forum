<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delegation_members', function (Blueprint $table) {
            if (!Schema::hasColumn('delegation_members', 'skill_id')) {
                $table->foreignId('skill_id')->nullable()->constrained('skills')->onDelete('set null')->after('member_type');
            }
            if (!Schema::hasColumn('delegation_members', 'status')) {
                $table->string('status', 30)->default('APPROVED')->after('member_type'); // PENDING, APPROVED, REJECTED
            }
            if (!Schema::hasColumn('delegation_members', 'nin_number')) {
                $table->string('nin_number')->nullable()->after('passport_number');
            }
            if (!Schema::hasColumn('delegation_members', 'suit_size')) {
                $table->string('suit_size', 20)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('delegation_members', 'shoe_size')) {
                $table->string('shoe_size', 20)->nullable()->after('suit_size');
            }
            if (!Schema::hasColumn('delegation_members', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('departure_flight');
            }
            if (!Schema::hasColumn('delegation_members', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('rejection_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('delegation_members', function (Blueprint $table) {
            $table->dropForeign(['skill_id']);
            $table->dropColumn([
                'skill_id',
                'status',
                'nin_number',
                'suit_size',
                'shoe_size',
                'rejection_reason',
                'photo_path',
            ]);
        });
    }
};
