<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'verification_token')) {
                $table->string('verification_token')->nullable()->unique()->after('registration_number');
            }
            if (!Schema::hasColumn('registrations', 'suit_size')) {
                $table->string('suit_size')->nullable()->after('status');
            }
            if (!Schema::hasColumn('registrations', 'shoe_size')) {
                $table->string('shoe_size')->nullable()->after('suit_size');
            }
            if (!Schema::hasColumn('registrations', 'height_cm')) {
                $table->integer('height_cm')->nullable()->after('shoe_size');
            }
            if (!Schema::hasColumn('registrations', 'national_id_pdf_path')) {
                $table->string('national_id_pdf_path')->nullable()->after('height_cm');
            }
            if (!Schema::hasColumn('registrations', 'passport_pdf_path')) {
                $table->string('passport_pdf_path')->nullable()->after('national_id_pdf_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'verification_token',
                'suit_size',
                'shoe_size',
                'height_cm',
                'national_id_pdf_path',
                'passport_pdf_path',
            ]);
        });
    }
};
