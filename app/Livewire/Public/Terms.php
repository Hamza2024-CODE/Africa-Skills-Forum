<?php

namespace App\Livewire\Public;

use App\Models\LegalContent;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Terms extends Component
{
    public string $title = '';
    public string $content = '';
    public string $version = '1.0';
    public string $updatedAt = '';

    public function mount(SettingsEngine $settings)
    {
        $doc = LegalContent::where('key', 'terms')->where('is_published', true)->first();

        if ($doc) {
            $this->title = $doc->getLocalized('title');
            $this->content = $doc->getLocalized('content');
            $this->version = $doc->version;
            $this->updatedAt = optional($doc->last_updated_at)->format('Y-m-d') ?? date('Y-m-d');
        } else {
            $locale = app()->getLocale();
            $this->title = __('messages.terms_of_service') ?? 'شروط وأحكام الاستخدام الرسمية';
            $this->content = $settings->get("terms_content_{$locale}", 'شروط وأحكام الاستخدام الرسمية الخاصة بالمشاركة والتسجيل في أولمبياد المهن بالجزائر (WSAP). يلتزم المتربصون والخبراء والوفود بكافة اللوائح والتوجيهات التنظيمية.');
            $this->version = '1.0';
            $this->updatedAt = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.public.terms');
    }
}
