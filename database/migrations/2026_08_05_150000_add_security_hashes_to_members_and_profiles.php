<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('delegation_members')) {
            Schema::table('delegation_members', function (Blueprint $table) {
                if (!Schema::hasColumn('delegation_members', 'photo_hash')) {
                    $table->string('photo_hash', 64)->nullable()->index();
                }
                if (!Schema::hasColumn('delegation_members', 'document_hash')) {
                    $table->string('document_hash', 64)->nullable()->index();
                }
            });
        }

        if (Schema::hasTable('participant_profiles')) {
            Schema::table('participant_profiles', function (Blueprint $table) {
                if (!Schema::hasColumn('participant_profiles', 'photo_hash')) {
                    $table->string('photo_hash', 64)->nullable()->index();
                }
                if (!Schema::hasColumn('participant_profiles', 'document_hash')) {
                    $table->string('document_hash', 64)->nullable()->index();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('delegation_members')) {
            Schema::table('delegation_members', function (Blueprint $table) {
                $table->dropColumn(['photo_hash', 'document_hash']);
            });
        }
        if (Schema::hasTable('participant_profiles')) {
            Schema::table('participant_profiles', function (Blueprint $table) {
                $table->dropColumn(['photo_hash', 'document_hash']);
            });
        }
    }
};
