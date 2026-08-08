<?php

namespace App\Events\Venue;

use App\Models\VenuePoi;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VenuePoiStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public VenuePoi $poi;
    public string $newStatus;

    public function __construct(VenuePoi $poi, string $newStatus)
    {
        $this->poi       = $poi;
        $this->newStatus = $newStatus;
    }
}
