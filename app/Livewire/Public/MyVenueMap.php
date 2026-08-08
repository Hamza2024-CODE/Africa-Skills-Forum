<?php

namespace App\Livewire\Public;

use App\Services\Venue\VenueOperationsService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class MyVenueMap extends Component
{
    public function render()
    {
        $user = Auth::user();
        $opsData = app(VenueOperationsService::class)->getPersonalizedDigitalTwinData($user);

        return view('livewire.public.my-venue-map', [
            'venue' => $opsData['venue'] ?? [],
            'user'  => $opsData['user'] ?? null,
            'pois'  => $opsData['personalizedPois'] ?? [],
        ]);
    }
}
