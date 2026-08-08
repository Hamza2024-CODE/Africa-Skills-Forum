<?php

namespace App\Livewire\Public;

use App\Services\Venue\VenueOperationsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class KioskVenueMap extends Component
{
    public function render()
    {
        $opsData = app(VenueOperationsService::class)->getPublicDigitalTwinData();

        return view('livewire.public.kiosk-venue-map', [
            'venue' => $opsData['venue'] ?? [],
            'pois'  => $opsData['pois'] ?? [],
        ]);
    }
}
