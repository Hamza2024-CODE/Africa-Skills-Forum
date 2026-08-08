<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            if (!Schema::hasColumn('countries', 'is_african')) {
                $table->boolean('is_african')->default(true)->after('flag');
            }
            if (!Schema::hasColumn('countries', 'nationality_ar')) {
                $table->string('nationality_ar')->nullable()->after('name_en');
            }
            if (!Schema::hasColumn('countries', 'nationality_fr')) {
                $table->string('nationality_fr')->nullable()->after('nationality_ar');
            }
            if (!Schema::hasColumn('countries', 'nationality_en')) {
                $table->string('nationality_en')->nullable()->after('nationality_fr');
            }
        });
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn(['is_african', 'nationality_ar', 'nationality_fr', 'nationality_en']);
        });
    }
};
