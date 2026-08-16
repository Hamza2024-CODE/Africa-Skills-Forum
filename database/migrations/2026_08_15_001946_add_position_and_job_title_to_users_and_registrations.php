<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'position')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('position')->nullable()->after('email');
            });
        }

        if (!Schema::hasColumn('registrations', 'job_title')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('job_title')->nullable()->after('status');
            });
        }

        if (!Schema::hasColumn('registrations', 'organization_name')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('organization_name')->nullable()->after('job_title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'position')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('position');
            });
        }

        if (Schema::hasColumn('registrations', 'job_title')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn(['job_title', 'organization_name']);
            });
        }
    }
};
