<?php

namespace App\Livewire\Admin;

use App\Models\Album;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class MediaManagerDashboard extends Component
{
    public $newsCount = 0;
    public $eventsCount = 0;
    public $albumsCount = 0;
    public $videosCount = 0;

    public function mount()
    {
        $this->newsCount = NewsArticle::count();
        $this->eventsCount = Event::count();
        $this->albumsCount = Album::count();
        $this->videosCount = Video::count();
    }

    public function render()
    {
        return view('livewire.admin.media-manager-dashboard');
    }
}
