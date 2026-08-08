<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('venue_pois', 'revision')) {
            Schema::table('venue_pois', function (Blueprint $table) {
                $table->integer('revision')->default(1)->after('pos_z');
                $table->decimal('rot_x', 8, 2)->default(0.00)->after('revision');
                $table->decimal('rot_y', 8, 2)->default(0.00)->after('rot_x');
                $table->decimal('rot_z', 8, 2)->default(0.00)->after('rot_y');
                $table->decimal('scale_x', 8, 2)->default(1.00)->after('rot_z');
                $table->decimal('scale_y', 8, 2)->default(1.00)->after('scale_x');
                $table->decimal('scale_z', 8, 2)->default(1.00)->after('scale_y');
            });
        }

        if (!Schema::hasColumn('venue_buildings', 'revision')) {
            Schema::table('venue_buildings', function (Blueprint $table) {
                $table->integer('revision')->default(1)->after('scale_z');
            });
        }
    }

    public function down(): void
    {
        Schema::table('venue_pois', function (Blueprint $table) {
            $table->dropColumn(['revision', 'rot_x', 'rot_y', 'rot_z', 'scale_x', 'scale_y', 'scale_z']);
        });

        Schema::table('venue_buildings', function (Blueprint $table) {
            $table->dropColumn('revision');
        });
    }
};
