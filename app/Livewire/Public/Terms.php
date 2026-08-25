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
        $doc = LegalContent::where('key', 'terms')->first();

        $contentAr = "African Skills Policy Forum — Terms & Conditions\nشروط استخدام المنصة الرسمية لمنتدى السياسات الأفريقية للمهارات تحكم قواعد التسجيل، والاعتماد الرسمي، والمشاركة في الجلسات والورشات التخصصية، والالتزام باللوائح والتعليمات التنظيمية الصادرة عن لجنة المنظمين.\n\n1. القبول والالتزام:\nبمجرد استخدامك للمنصة أو التسجيل فيها، فإنك توافق كاملاً على الالتزام بشروط وأحكام الاستخدام واللوائح التنظيمية للمنتدى.\n\n2. الاعتماد الرسمي والسلوك:\nيتحمل المشارك مسؤولية دقة البيانات المدخلة في استمارة الاعتماد. يُحظر استخدام المنصة لأي أغراض غير قانونية أو التسبب في تعطيل خدماتها.\n\n3. حقوق الملكية الفكرية:\nجميع المحتويات، العلامات، والشعارات المعروضة على المنصة هي ملكية حصرية لـ African Skills Policy Forum ووزارة التكوين والتعليم المهنيين ومفوضية الاتحاد الأفريقي.";

        $contentFr = "Conditions Générales d'Utilisation — Forum des Politiques Africaines des Compétences\nLes présentes conditions régissent l'inscription, l'accréditation officielle et la participation aux sessions du Forum.\n\n1. Acceptation et Engagement:\nEn utilisant la plateforme ou en vous y inscrivant, vous acceptez pleinement les termes d'utilisation et les règlements du Forum.\n\n2. Accréditation Officielle et Conduite:\nLe participant est responsable de l'exactitude des informations renseignées. Toute utilisation illégale ou tentative de perturbation est strictement interdite.\n\n3. Droits de Propriété Intellectuelle:\nTous les contenus, logos et marques affichés sont la propriété exclusive du Forum des Politiques Africaines des Compétences, du Ministère de la Formation et de l'Enseignement Professionnels et de la Commission de l'Union Africaine.";

        $contentEn = "African Skills Policy Forum — Terms & Conditions\nThe official terms of use for the African Skills Policy Forum platform govern registration, official accreditation, participation in sessions and specialized workshops, and compliance with rules issued by the organizing committee.\n\n1. Acceptance & Compliance:\nBy accessing or registering on the platform, you fully agree to comply with these terms of use and forum regulations.\n\n2. Official Accreditation & Conduct:\nParticipants are solely responsible for the accuracy of information entered in accreditation forms. Using the platform for unlawful purposes or attempting to disrupt services is strictly prohibited.\n\n3. Intellectual Property Rights:\nAll content, branding, trademarks, and logos displayed on this platform are the exclusive property of the African Skills Policy Forum, the Ministry of Vocational Education and Training, and the African Union Commission.";

        if ($doc) {
            $doc->update([
                'title_ar' => 'شروط وضوابط الاستخدام الرسمية',
                'title_fr' => 'Conditions Générales d\'Utilisation',
                'title_en' => 'Terms & Conditions',
                'content_ar' => $contentAr,
                'content_fr' => $contentFr,
                'content_en' => $contentEn,
                'is_published' => true,
            ]);
            $this->title = $doc->getLocalized('title');
            $this->content = $doc->getLocalized('content');
            $this->version = $doc->version ?? '1.0';
            $this->updatedAt = optional($doc->last_updated_at)->format('Y-m-d') ?? date('Y-m-d');
        } else {
            $locale = app()->getLocale();
            $this->title = match($locale) {
                'fr' => 'Conditions Générales d\'Utilisation',
                'en' => 'Terms & Conditions',
                default => 'شروط وضوابط الاستخدام الرسمية',
            };
            $this->content = match($locale) {
                'fr' => $contentFr,
                'en' => $contentEn,
                default => $contentAr,
            };
            $this->version = '1.0';
            $this->updatedAt = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.public.terms');
    }
}
