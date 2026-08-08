<?php

namespace App\Livewire\Public;

use App\Models\Album;
use App\Models\Establishment;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Skill;
use App\Models\Video;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';
    public string $selectedCategory = 'all';

    public function setCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        $skills = collect();
        $news = collect();
        $events = collect();
        $establishments = collect();
        $partners = collect();
        $albums = collect();
        $videos = collect();

        $q = trim($this->query);
        $hasQuery = mb_strlen($q) >= 1;

        // 1. Search Trade Skills (التخصصات والمهن)
        if (in_array($this->selectedCategory, ['all', 'skills'])) {
            $skillsQuery = Skill::where('is_active', true);
            if ($hasQuery) {
                $skillsQuery->where(function($builder) use ($q) {
                    $builder->where('name_ar', 'like', "%{$q}%")
                        ->orWhere('name_fr', 'like', "%{$q}%")
                        ->orWhere('name_en', 'like', "%{$q}%")
                        ->orWhere('code', 'like', "%{$q}%")
                        ->orWhere('description_ar', 'like', "%{$q}%");
                });
            }
            $skills = $skillsQuery->limit($hasQuery ? 24 : 12)->get();
        }

        // 2. Search News Articles (الأخبار والمستجدات)
        if (in_array($this->selectedCategory, ['all', 'news'])) {
            $newsQuery = NewsArticle::where('status', 'PUBLISHED');
            if ($hasQuery) {
                $newsQuery->where(function($builder) use ($q) {
                    $builder->where('title_ar', 'like', "%{$q}%")
                        ->orWhere('title_fr', 'like', "%{$q}%")
                        ->orWhere('title_en', 'like', "%{$q}%")
                        ->orWhere('excerpt_ar', 'like', "%{$q}%");
                });
            }
            $news = $newsQuery->orderBy('published_at', 'desc')->limit(10)->get();
        }

        // 3. Search Events (الأجندة والفعاليات)
        if (in_array($this->selectedCategory, ['all', 'events'])) {
            $eventsQuery = Event::where('status', 'PUBLISHED');
            if ($hasQuery) {
                $eventsQuery->where(function($builder) use ($q) {
                    $builder->where('title_ar', 'like', "%{$q}%")
                        ->orWhere('title_fr', 'like', "%{$q}%")
                        ->orWhere('title_en', 'like', "%{$q}%")
                        ->orWhere('venue', 'like', "%{$q}%")
                        ->orWhere('address', 'like', "%{$q}%");
                });
            }
            $events = $eventsQuery->orderBy('start_at', 'desc')->limit(10)->get();
        }

        // 4. Search Establishments (المؤسسات التدريبية والولايات)
        if (in_array($this->selectedCategory, ['all', 'establishments'])) {
            if (class_exists(Establishment::class)) {
                $estQuery = Establishment::query();
                if ($hasQuery) {
                    $estQuery->where(function($builder) use ($q) {
                        $builder->where('name', 'like', "%{$q}%")
                            ->orWhere('wilaya', 'like', "%{$q}%")
                            ->orWhere('daira', 'like', "%{$q}%")
                            ->orWhere('commune', 'like', "%{$q}%");
                    });
                }
                $establishments = $estQuery->limit(10)->get();
            }
        }

        // 5. Search Partners & Sponsors (الشركاء والرعاة)
        if (in_array($this->selectedCategory, ['all', 'partners'])) {
            $partnerQuery = Partner::query();
            if ($hasQuery) {
                $partnerQuery->where(function($builder) use ($q) {
                    $builder->where('name_ar', 'like', "%{$q}%")
                        ->orWhere('name_fr', 'like', "%{$q}%")
                        ->orWhere('name_en', 'like', "%{$q}%");
                });
            }
            $partners = $partnerQuery->limit(12)->get();
        }

        // 6. Search Photo Albums & Videos
        if (in_array($this->selectedCategory, ['all', 'media'])) {
            $albumQuery = Album::query();
            $videoQuery = Video::query();
            if ($hasQuery) {
                $albumQuery->where(function($b) use ($q) {
                    $b->where('title_ar', 'like', "%{$q}%")->orWhere('title_fr', 'like', "%{$q}%");
                });
                $videoQuery->where(function($b) use ($q) {
                    $b->where('title_ar', 'like', "%{$q}%")->orWhere('title_fr', 'like', "%{$q}%");
                });
            }
            $albums = $albumQuery->limit(6)->get();
            $videos = $videoQuery->limit(6)->get();
        }

        $totalResults = $skills->count() + $news->count() + $events->count() + $establishments->count() + $partners->count() + $albums->count() + $videos->count();

        return view('livewire.public.global-search', [
            'skills'         => $skills,
            'news'           => $news,
            'events'         => $events,
            'establishments' => $establishments,
            'partners'       => $partners,
            'albums'         => $albums,
            'videos'         => $videos,
            'totalResults'   => $totalResults,
        ])->layout('components.layouts.public');
    }
}
