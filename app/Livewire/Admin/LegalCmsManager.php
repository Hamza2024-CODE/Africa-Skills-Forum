<?php

namespace App\Livewire\Admin;

use App\Models\LegalContent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class LegalCmsManager extends Component
{
    public string $activeKey = 'privacy';

    public string $titleAr = '';
    public string $titleFr = '';
    public string $titleEn = '';

    public string $contentAr = '';
    public string $contentFr = '';
    public string $contentEn = '';

    public bool $isPublished = true;
    public string $version = '1.0';

    public string $successMessage = '';

    public function mount()
    {
        $this->loadKey('privacy');
    }

    public function loadKey(string $key)
    {
        $this->activeKey = $key;
        $this->successMessage = '';

        $doc = LegalContent::firstOrCreate(['key' => $key], [
            'title_ar' => $key === 'privacy' ? 'سياسة الخصوصية الرسمية' : 'شروط وأحكام الاستخدام',
            'title_fr' => $key === 'privacy' ? 'Politique de Confidentialité' : 'Conditions d\'utilisation',
            'title_en' => $key === 'privacy' ? 'Privacy Policy' : 'Terms of Service',
            'content_ar' => $key === 'privacy'
                ? 'تلتزم المنصة الوطنية لحماية بيانات جميع المشاركين والزوار وفق التشريعات الوطنية والتنظيمات الدولية.'
                : 'شروط استخدام المنصة الوطنية لأولمبياد المهن تحكم قواعد التسجيل والمشاركة والتقييم.',
            'content_fr' => $key === 'privacy'
                ? 'La plateforme nationale s\'engage à protéger les données personnelles selon les normes légales.'
                : 'Les conditions d\'utilisation régissent l\'inscription et la participation.',
            'content_en' => $key === 'privacy'
                ? 'The national platform commits to protecting personal data in accordance with regulations.'
                : 'Terms of use govern registration, participation, and competition rules.',
            'is_published' => true,
            'version' => '1.0',
            'last_updated_at' => now(),
        ]);

        $this->titleAr = $doc->title_ar ?? '';
        $this->titleFr = $doc->title_fr ?? '';
        $this->titleEn = $doc->title_en ?? '';

        $this->contentAr = $doc->content_ar ?? '';
        $this->contentFr = $doc->content_fr ?? '';
        $this->contentEn = $doc->content_en ?? '';

        $this->isPublished = (bool) $doc->is_published;
        $this->version = $doc->version ?? '1.0';
    }

    public function saveLegalDoc()
    {
        LegalContent::updateOrCreate(
            ['key' => $this->activeKey],
            [
                'title_ar' => $this->titleAr,
                'title_fr' => $this->titleFr,
                'title_en' => $this->titleEn,
                'content_ar' => $this->contentAr,
                'content_fr' => $this->contentFr,
                'content_en' => $this->contentEn,
                'is_published' => $this->isPublished,
                'version' => $this->version,
                'last_updated_at' => now(),
            ]
        );

        $this->successMessage = 'تم حفظ وبلورة المستند القانوني بنجاح في قاعدة البيانات MySQL.';
    }

    public function render()
    {
        return view('livewire.admin.legal-cms-manager');
    }
}
