<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('equipment_items', 'skill_id')) {
            Schema::table('equipment_items', function (Blueprint $table) {
                $table->foreignId('skill_id')->nullable()->after('category_id')->constrained('skills')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('equipment_items', 'skill_id')) {
            Schema::table('equipment_items', function (Blueprint $table) {
                $table->dropForeign(['skill_id']);
                $table->dropColumn('skill_id');
            });
        }
    }
};
