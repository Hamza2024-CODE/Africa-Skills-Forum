<?php

namespace App\Livewire\Public;

use App\Services\Venue\VenueOperationsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class VenueMap extends Component
{
    public string $activeLayer = 'ALL';
    public string $searchQuery = '';
    public ?int $selectedPoiId = null;

    public function mount(VenueOperationsService $opsService): void
    {
        // Loaded dynamically via API snapshot
    }

    public function render()
    {
        $opsData = app(VenueOperationsService::class)->getPublicDigitalTwinData();

        return view('livewire.public.venue-map', [
            'venue'          => $opsData['venue'] ?? [],
            'zones'          => $opsData['zones'] ?? [],
            'pois'           => $opsData['pois'] ?? [],
            'customBoundary' => $opsData['customBoundary'] ?? null,
        ]);
    }
}
