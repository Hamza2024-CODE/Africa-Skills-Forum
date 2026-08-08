<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Venue Master Definition (Geo ↔ 3D Coordinates)
        Schema::create('venue_maps', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique()->default('ORAN_VILLAGE_2026');
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->decimal('latitude', 10, 8)->default(35.74718000);
            $table->decimal('longitude', 11, 8)->default(-0.53518000);
            $table->decimal('altitude', 8, 2)->default(120.00);
            $table->integer('zoom_level')->default(18);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Dynamic SVG Icon Registry (No-Emoji System Standard)
        Schema::create('venue_poi_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_key', 50)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('icon_name', 50)->default('trophy');
            $table->text('svg_raw');
            $table->string('primary_color_hex', 20)->default('#0284C7');
            $table->string('bg_color_hex', 20)->default('#E0F2FE');
            $table->string('marker_style_preset', 50)->default('glass_floating_badge');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Asset Registry (3D Models, Textures, Icons, Floorplans)
        Schema::create('venue_map_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_map_id')->constrained('venue_maps')->cascadeOnDelete();
            $table->enum('asset_type', ['VENUE_MODEL', 'BUILDING_MODEL', 'FLOOR_PLAN', 'TEXTURE', 'ICON', 'MATERIAL', 'ENVIRONMENT']);
            $table->string('asset_key', 100)->unique();
            $table->string('file_path');
            $table->string('file_hash', 64)->nullable();
            $table->bigInteger('file_size_bytes')->default(0);
            $table->string('version', 20)->default('1.0.0');
            $table->boolean('is_active')->default(true);
            $table->json('metadata_json')->nullable();
            $table->timestamps();
        });

        // 4. Visual Layers (Competition, Catering, Accommodation, Transport, Medical, Security, Meetings)
        Schema::create('venue_map_layers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_map_id')->constrained('venue_maps')->cascadeOnDelete();
            $table->string('layer_key', 50)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('icon_name', 50)->default('layer');
            $table->string('color_hex', 20)->default('#0284C7');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible_public')->default(true);
            $table->boolean('is_visible_personal')->default(true);
            $table->timestamps();
        });

        // 5. Spatial Zones
        Schema::create('venue_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_map_id')->constrained('venue_maps')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->enum('zone_type', ['residential', 'competition', 'international', 'services']);
            $table->string('color_hex', 20)->default('#0284C7');
            $table->string('access_rule_code', 50)->default('ALL');
            $table->timestamps();
        });

        // 6. Buildings & Halls
        Schema::create('venue_buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_zone_id')->constrained('venue_zones')->cascadeOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained('venue_map_assets')->nullOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('mesh_key', 100)->default('building_a');
            $table->decimal('pos_x', 8, 2)->default(0.00);
            $table->decimal('pos_y', 8, 2)->default(0.00);
            $table->decimal('pos_z', 8, 2)->default(0.00);
            $table->decimal('rot_x', 8, 2)->default(0.00);
            $table->decimal('rot_y', 8, 2)->default(0.00);
            $table->decimal('rot_z', 8, 2)->default(0.00);
            $table->decimal('scale_x', 8, 2)->default(1.00);
            $table->decimal('scale_y', 8, 2)->default(1.00);
            $table->decimal('scale_z', 8, 2)->default(1.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 7. Building Floors
        Schema::create('venue_floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_building_id')->constrained('venue_buildings')->cascadeOnDelete();
            $table->integer('floor_number')->default(0);
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('plan_svg_path')->nullable();
            $table->timestamps();
        });

        // 8. Rooms & Workshops
        Schema::create('venue_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_floor_id')->constrained('venue_floors')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name_ar');
            $table->string('name_fr');
            $table->string('name_en');
            $table->decimal('area_sqm', 8, 2)->default(150.00);
            $table->integer('capacity')->default(50);
            $table->timestamps();
        });

        // 9. POIs (Dynamic Reference Resolver & Icon Registry Link)
        Schema::create('venue_pois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_poi_type_id')->constrained('venue_poi_types')->cascadeOnDelete();
            $table->foreignId('venue_layer_id')->constrained('venue_map_layers')->cascadeOnDelete();
            $table->foreignId('venue_building_id')->constrained('venue_buildings')->cascadeOnDelete();
            $table->foreignId('venue_room_id')->nullable()->constrained('venue_rooms')->nullOnDelete();
            $table->enum('poi_type', ['SKILL', 'RESTAURANT', 'ACCOMMODATION', 'TRANSPORT_STATION', 'MEETING', 'SECURITY_ZONE', 'MEDICAL_POINT', 'INFO_DESK']);
            $table->string('reference_type', 50)->nullable(); // RESTAURANT, SKILL, MEAL_SLOT, SCHEDULE_EVENT, ACCOMMODATION, TRANSPORT, MEETING
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('title_ar');
            $table->string('title_fr');
            $table->string('title_en');
            $table->enum('status', ['OPEN', 'CLOSED', 'LIVE_COMPETITION', 'FULL', 'RESTRICTED'])->default('OPEN');
            $table->integer('capacity')->default(300);
            $table->string('access_role', 50)->default('ALL');
            $table->decimal('pos_x', 8, 2)->default(0.00);
            $table->decimal('pos_y', 8, 2)->default(0.00);
            $table->decimal('pos_z', 8, 2)->default(0.00);
            $table->timestamps();

            $table->index(['reference_type', 'reference_id']);
            $table->index('poi_type');
            $table->index('status');
        });

        // 10. Spatial Graph Nodes
        Schema::create('venue_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_building_id')->nullable()->constrained('venue_buildings')->nullOnDelete();
            $table->string('node_code', 50)->unique();
            $table->decimal('pos_x', 8, 2);
            $table->decimal('pos_y', 8, 2);
            $table->decimal('pos_z', 8, 2);
            $table->boolean('is_accessible')->default(true);
            $table->boolean('is_emergency_exit')->default(false);
            $table->timestamps();
        });

        // 11. Spatial Graph Edges (Connections & Distances)
        Schema::create('venue_edges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_node_id')->constrained('venue_nodes')->cascadeOnDelete();
            $table->foreignId('to_node_id')->constrained('venue_nodes')->cascadeOnDelete();
            $table->decimal('distance_meters', 8, 2);
            $table->integer('walk_seconds');
            $table->boolean('is_accessible')->default(true);
            $table->timestamps();

            $table->index(['from_node_id', 'to_node_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venue_edges');
        Schema::dropIfExists('venue_nodes');
        Schema::dropIfExists('venue_pois');
        Schema::dropIfExists('venue_rooms');
        Schema::dropIfExists('venue_floors');
        Schema::dropIfExists('venue_buildings');
        Schema::dropIfExists('venue_zones');
        Schema::dropIfExists('venue_map_layers');
        Schema::dropIfExists('venue_map_assets');
        Schema::dropIfExists('venue_poi_types');
        Schema::dropIfExists('venue_maps');
    }
};
