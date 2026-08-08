<?php

namespace App\Livewire\Public;

use App\Models\Edition;
use App\Models\LiveTvAnnouncement;
use App\Models\LiveTvSlide;
use App\Services\SettingsEngine;
use Livewire\Component;

class LiveTvDisplay extends Component
{
    public int $currentSlideIndex = 0;

    public function render()
    {
        $edition       = Edition::where('is_active', true)->first();
        $slides        = LiveTvSlide::where('is_active', true)->orderBy('sort_order')->get();
        $announcements = LiveTvAnnouncement::where('is_active', true)->get();
        $liveStreamUrl = app(SettingsEngine::class)->get('live_stream_url', '');

        return view('livewire.public.live-tv', [
            'edition'       => $edition,
            'slides'        => $slides,
            'announcements' => $announcements,
            'liveStreamUrl' => $liveStreamUrl,
        ])->layout('components.layouts.live-tv');
    }
}
