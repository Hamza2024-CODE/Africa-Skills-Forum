<?php

namespace App\Livewire\Public;

use App\Models\Partner;
use App\Services\HomepageStatisticsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Partners extends Component
{
    public function render(HomepageStatisticsService $statsService)
    {
        $featuredPartners = Partner::where('status', 'ACTIVE')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('name_ar')
            ->get();

        $allPartners = Partner::where('status', 'ACTIVE')
            ->orderBy('sort_order')
            ->orderBy('name_ar')
            ->get();

        return view('livewire.public.partners', [
            'featuredPartners' => $featuredPartners,
            'allPartners'      => $allPartners,
            'stats'            => $statsService->getStatistics(),
        ]);
    }
}
