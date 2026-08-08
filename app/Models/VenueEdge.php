<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueEdge extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_node_id',
        'to_node_id',
        'distance_meters',
        'walk_seconds',
        'is_accessible',
    ];

    protected $casts = [
        'distance_meters' => 'float',
        'walk_seconds'    => 'integer',
        'is_accessible'   => 'boolean',
    ];

    public function fromNode(): BelongsTo
    {
        return $this->belongsTo(VenueNode::class, 'from_node_id');
    }

    public function toNode(): BelongsTo
    {
        return $this->belongsTo(VenueNode::class, 'to_node_id');
    }
}
