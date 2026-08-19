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
            $this->content = $settings->get("terms_content_{$locale}", "شروط وأحكام الاستخدام — Africa Skills Forum Terms & Conditions\n\nشروط استخدام منصة منتدى السياسات الإفريقية للمهارات تحكم قواعد التسجيل، والاعتماد الرسمي، والمشاركة في الجلسات والورشات التخصصية، والالتزام باللوائح والتعليمات التنظيمية الصادرة عن لجنة المنظمين.\n\n1. القبول والالتزام:\nبمجرد استخدامك للمنصة أو التسجيل فيها، فإنك توافق كاملاً على الالتزام بشروط وأحكام الاستخدام واللوائح التنظيمية للمنتدى.\n\n2. الاعتماد الرسمي والسلوك:\nيتحمل المشارك مسؤولية دقة البيانات المدخلة في استمارة الاعتماد. يُحظر استخدام المنصة لأي أغراض غير قانونية أو التسبب في تعطيل خدماتها.\n\n3. حقوق الملكية الفكرية:\nجميع المحتويات، العلامات، والشعارات المعروضة على المنصة هي ملكية حصرية لـ Africa Skills Forum ووزارة التكوين والتعليم المهنيين ومفوضية الاتحاد الأفريقي.");
            $this->version = '1.0';
            $this->updatedAt = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.public.terms');
    }
}
