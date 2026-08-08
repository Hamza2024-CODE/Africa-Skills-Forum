<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueNode extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_building_id',
        'node_code',
        'pos_x',
        'pos_y',
        'pos_z',
        'is_accessible',
        'is_emergency_exit',
    ];

    protected $casts = [
        'pos_x'             => 'float',
        'pos_y'             => 'float',
        'pos_z'             => 'float',
        'is_accessible'     => 'boolean',
        'is_emergency_exit' => 'boolean',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(VenueBuilding::class, 'venue_building_id');
    }

    public function outgoingEdges(): HasMany
    {
        return $this->hasMany(VenueEdge::class, 'from_node_id');
    }

    public function incomingEdges(): HasMany
    {
        return $this->hasMany(VenueEdge::class, 'to_node_id');
    }
}
