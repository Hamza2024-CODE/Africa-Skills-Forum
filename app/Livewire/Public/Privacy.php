<?php

namespace App\Livewire\Public;

use App\Models\LegalContent;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Privacy extends Component
{
    public string $title = '';
    public string $content = '';
    public string $version = '1.0';
    public string $updatedAt = '';

    public function mount(SettingsEngine $settings)
    {
        $doc = LegalContent::where('key', 'privacy')->where('is_published', true)->first();

        if ($doc) {
            $this->title = $doc->getLocalized('title');
            $this->content = $doc->getLocalized('content');
            $this->version = $doc->version;
            $this->updatedAt = optional($doc->last_updated_at)->format('Y-m-d') ?? date('Y-m-d');
        } else {
            $locale = app()->getLocale();
            $this->title = __('messages.privacy_policy') ?? 'سياسة الخصوصية وحماية البيانات';
            $this->content = $settings->get("privacy_content_{$locale}", "تلتزم منصة Africa Skills Forum بحماية خصوصية بيانات جميع المشاركين والزوار وفقاً للتشريعات الوطنية المعمول بها والتنظيمات الدولية ذات الصلة، مع تطبيق معايير أمان متقدمة لضمان سرية المعلومات الشخصية ومنع أي استخدام غير مصرح به لها.\n\nجمع واستخدام البيانات:\n• جمع البيانات الأساسية مثل الاسم، والبريد الإلكتروني، ورقم الهاتف عند التسجيل والاعتماد الرسمي.\n• استخدام البيانات حصرياً لغرض تحسين تجربة المستخدم وإدارة الفعاليات والأنشطة الخاصة بالمنصة.\n• عدم مشاركة أو بيع المعلومات الشخصية لأي جهات خارجية تجارية دون إذن صريح.\n\nأمان وحماية المعلومات:\n• استخدام تقنيات تشفير قوية لحماية البيانات أثناء النقل والتخزين.\n• تقييد الوصول إلى البيانات الشخصية ليقتصر فقط على الموظفين والمسؤولين المخولين بذلك.\n• تحديث أنظمة الحماية بشكل دوري لمواجهة أي تهديدات سيبرانية محتملة.\n\nحقوق المستخدم وملفات تعريف الارتباط (Cookies):\n• يمتلك المشارك والزائر الحق في معرفة أو تعديل أو طلب حذف بياناته الشخصية وفق الضوابط.\n• تستخدم المنصة ملفات تعريف الارتباط (Cookies) لتحسين أداء النظام وتخصيص تجربة التصفح بشكل آمن.");
            $this->version = '1.0';
            $this->updatedAt = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.public.privacy');
    }
}
