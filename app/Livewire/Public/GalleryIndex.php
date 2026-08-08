<?php

namespace App\Livewire\Public;

use App\Models\Album;
use Livewire\Component;

class GalleryIndex extends Component
{
    public ?int $selectedAlbumId = null;
    public bool $showModal = false;

    public function openAlbum(int $albumId)
    {
        $this->selectedAlbumId = $albumId;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedAlbumId = null;
    }

    public function render()
    {
        $albums = Album::with(['coverMedia', 'mediaItems'])
            ->where('status', 'PUBLISHED')
            ->orderBy('published_at', 'desc')
            ->get();

        // Fallback: if no published albums, get all active albums
        if ($albums->isEmpty()) {
            $albums = Album::with(['coverMedia', 'mediaItems'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $activeAlbum = $this->selectedAlbumId ? Album::with(['coverMedia', 'mediaItems'])->find($this->selectedAlbumId) : null;

        return view('livewire.public.gallery-index', [
            'albums'      => $albums,
            'activeAlbum' => $activeAlbum,
        ])->layout('components.layouts.public');
    }
}
