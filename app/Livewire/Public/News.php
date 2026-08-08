<?php

namespace App\Livewire\Public;

use App\Models\NewsArticle;
use Livewire\Attributes\Layout;
use Livewire\Component;

class News extends Component
{
    public ?NewsArticle $selectedArticle = null;
    public bool $modalOpen = false;
    public string $activePhoto = '';

    public function openArticle(int $id): void
    {
        $this->selectedArticle = NewsArticle::find($id);
        if ($this->selectedArticle) {
            $this->activePhoto = $this->selectedArticle->cover_url;
        }
        $this->modalOpen = true;
    }

    public function closeArticle(): void
    {
        $this->selectedArticle = null;
        $this->modalOpen = false;
        $this->activePhoto = '';
    }

    public function setActivePhoto(string $photoUrl): void
    {
        $this->activePhoto = $photoUrl;
    }

    #[Layout('components.layouts.public')]
    public function render()
    {
        $articles = NewsArticle::where('status', 'PUBLISHED')
            ->orderByDesc('published_at')
            ->get();

        return view('livewire.public.news', [
            'articles' => $articles,
        ]);
    }
}
