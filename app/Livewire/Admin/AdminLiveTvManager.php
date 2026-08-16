<?php

namespace App\Livewire\Admin;

use App\Models\LiveTvAnnouncement;
use App\Models\LiveTvSlide;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class AdminLiveTvManager extends Component
{
    use WithFileUploads;

    public string $liveStreamUrl = '';

    // Slide Creation Form
    public string $slideTitleAr = '';
    public string $slideTitleFr = '';
    public string $slideType = 'image';
    public string $slideContent = '';
    public mixed $slideImageFile = null;
    public int $slideDuration = 10;
    public int $slideSortOrder = 1;

    // Ticker Announcement Form
    public string $tickerTextAr = '';
    public string $tickerTextFr = '';

    public function mount(SettingsEngine $settings): void
    {
        $this->liveStreamUrl = $settings->get('live_stream_url', '');
    }

    public function saveStreamUrl(SettingsEngine $settings): void
    {
        $settings->set('live_stream_url', trim($this->liveStreamUrl));
        session()->flash('success_stream', app()->getLocale() === 'fr' ? 'URL du flux en direct enregistrée avec succès !' : (app()->getLocale() === 'en' ? 'Live stream URL updated successfully!' : 'تم حفظ وتحديث رابط البث المباشر بنجاح!'));
    }

    public function createSlide(): void
    {
        $this->validate([
            'slideTitleAr' => 'required|string|max:255',
            'slideDuration' => 'required|integer|min:3|max:120',
            'slideImageFile' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($this->slideImageFile) {
            $imagePath = $this->slideImageFile->store('live_tv/slides', 'public');
        }

        LiveTvSlide::create([
            'title_ar'             => $this->slideTitleAr,
            'title_fr'             => $this->slideTitleFr ?: $this->slideTitleAr,
            'slide_type'           => $this->slideType,
            'content'              => $this->slideContent,
            'image_url'            => $imagePath ? '/storage/' . $imagePath : null,
            'display_duration_sec' => $this->slideDuration,
            'sort_order'           => $this->slideSortOrder,
            'is_active'            => true,
        ]);

        $this->reset(['slideTitleAr', 'slideTitleFr', 'slideContent', 'slideImageFile', 'slideDuration']);
        session()->flash('success_slide', app()->getLocale() === 'fr' ? 'Diapositive ajoutée avec succès !' : (app()->getLocale() === 'en' ? 'Slide created successfully!' : 'تمت إضافة شريحة العرض بنجاح!'));
    }

    public function toggleSlide(int $id): void
    {
        $slide = LiveTvSlide::find($id);
        if ($slide) {
            $slide->update(['is_active' => !$slide->is_active]);
        }
    }

    public function deleteSlide(int $id): void
    {
        $slide = LiveTvSlide::find($id);
        if ($slide) {
            $slide->delete();
            session()->flash('success_slide', app()->getLocale() === 'fr' ? 'Diapositive supprimée !' : (app()->getLocale() === 'en' ? 'Slide deleted!' : 'تم حذف شريحة العرض!'));
        }
    }

    public function createAnnouncement(): void
    {
        $this->validate([
            'tickerTextAr' => 'required|string|max:500',
        ]);

        LiveTvAnnouncement::create([
            'ticker_text_ar' => $this->tickerTextAr,
            'ticker_text_fr' => $this->tickerTextFr ?: $this->tickerTextAr,
            'is_active'      => true,
        ]);

        $this->reset(['tickerTextAr', 'tickerTextFr']);
        session()->flash('success_ticker', app()->getLocale() === 'fr' ? 'Annonce ajoutée au bandeau !' : (app()->getLocale() === 'en' ? 'Ticker announcement added!' : 'تمت إضافة الخبر العاجل لشريط البث!'));
    }

    public function toggleAnnouncement(int $id): void
    {
        $announcement = LiveTvAnnouncement::find($id);
        if ($announcement) {
            $announcement->update(['is_active' => !$announcement->is_active]);
        }
    }

    public function deleteAnnouncement(int $id): void
    {
        $announcement = LiveTvAnnouncement::find($id);
        if ($announcement) {
            $announcement->delete();
            session()->flash('success_ticker', app()->getLocale() === 'fr' ? 'Annonce supprimée !' : (app()->getLocale() === 'en' ? 'Announcement deleted!' : 'تم حذف التنبيه!'));
        }
    }

    public function render()
    {
        $slides        = LiveTvSlide::orderBy('sort_order')->orderBy('id', 'desc')->get();
        $announcements = LiveTvAnnouncement::orderBy('id', 'desc')->get();

        return view('livewire.admin.live-tv-manager', [
            'slides'        => $slides,
            'announcements' => $announcements,
        ]);
    }
}
