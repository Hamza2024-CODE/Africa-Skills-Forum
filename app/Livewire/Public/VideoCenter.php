<?php

namespace App\Livewire\Public;

use App\Models\Video;
use Livewire\Component;

class VideoCenter extends Component
{
    public ?int $selectedVideoId = null;
    public bool $showVideoModal = false;

    public function playVideo(int $videoId)
    {
        $this->selectedVideoId = $videoId;
        $this->showVideoModal = true;
    }

    public function closeVideoModal()
    {
        $this->showVideoModal = false;
        $this->selectedVideoId = null;
    }

    public function render()
    {
        $videos = Video::where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->get();

        if ($videos->isEmpty()) {
            $videos = Video::orderBy('created_at', 'desc')->get();
        }

        $activeVideo = $this->selectedVideoId ? Video::find($this->selectedVideoId) : null;

        return view('livewire.public.video-center', [
            'videos'      => $videos,
            'activeVideo' => $activeVideo,
        ])->layout('components.layouts.public');
    }
}
