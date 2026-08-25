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
        $doc = LegalContent::where('key', 'privacy')->first();

        $contentAr = "تلتزم منصة منتدى السياسات الأفريقية للمهارات (African Skills Policy Forum) بحماية خصوصية بيانات جميع المشاركين والزوار وفقاً للتشريعات الوطنية المعمول بها والتنظيمات الدولية ذات الصلة، مع تطبيق معايير أمان متقدمة لضمان سرية المعلومات الشخصية ومنع أي استخدام غير مصرح به لها.\n\nجمع واستخدام البيانات:\n• جمع البيانات الأساسية مثل الاسم، والبريد الإلكتروني، ورقم الهاتف عند التسجيل والاعتماد الرسمي.\n• استخدام البيانات حصرياً لغرض تحسين تجربة المستخدم وإدارة الفعاليات والأنشطة الخاصة بـ منتدى السياسات الأفريقية للمهارات.\n• عدم مشاركة أو بيع المعلومات الشخصية لأي جهات خارجية تجارية دون إذن صريح.\n\nأمان وحماية المعلومات:\n• استخدام تقنيات تشفير قوية لضمان حماية البيانات أثناء النقل والتخزين.\n• تقييد الوصول إلى البيانات الشخصية ليقتصر فقط على الموظفين والمسؤولين المخولين بذلك.\n• تحديث أنظمة الحماية بشكل دوري لمواجهة أي تهديدات سيبرانية محتملة.\n\nحقوق المستخدم وملفات تعريف الارتباط (Cookies):\n• يمتلك المشارك والزائر الحق في معرفة أو تعديل أو طلب حذف بياناته الشخصية من المنصة وفق الضوابط التنظيمية.\n• تستخدم المنصة ملفات تعريف الارتباط (Cookies) لتحسين أداء النظام وتخصيص تجربة التصفح بشكل آمن.";

        $contentFr = "La plateforme du Forum des Politiques Africaines des Compétences s'engage à protéger la confidentialité des données de tous les participants et visiteurs conformément aux législations nationales en vigueur et aux réglementations internationales pertinentes.\n\nCollecte et Utilisation des Données:\n• Collecte d'informations de base telles que le nom complet, l'adresse e-mail et le numéro de téléphone lors de l'accréditation officielle.\n• Utilisation exclusive des données pour améliorer l'expérience utilisateur et gérer les événements du Forum.\n• Aucune vente ou partage des données personnelles à des tiers commerciaux sans consentement explicite.\n\nSécurité et Protection des Informations:\n• Emploi de technologies de chiffrement robustes pour sécuriser le stockage et la transmission des données.\n• Accès aux données strictly restreint au personnel et responsables autorisés.\n• Mise à jour régulière des systèmes de sécurité contre les cyber-menaces.\n\nDroits des Utilisateurs & Cookies:\n• Les participants disposent du droit de consulter, modifier ou demander la suppression de leurs données personnelles.\n• La plateforme utilise des cookies pour optimiser les performances du système et sécuriser la navigation.";

        $contentEn = "The African Skills Policy Forum platform is committed to protecting the privacy of all participants and visitors in accordance with applicable national laws and relevant international regulations, applying advanced security standards to ensure confidentiality and prevent unauthorized access.\n\nData Collection and Use:\n• Collection of basic information such as full name, email address, and phone number during official accreditation and registration.\n• Exclusive use of data to enhance user experience and manage events and activities related to the African Skills Policy Forum.\n• No sharing or selling of personal information to third-party commercial entities without explicit consent.\n\nInformation Security & Protection:\n• Use of robust encryption technologies to protect data during transmission and storage.\n• Restricting access to personal data strictly to authorized personnel and officers.\n• Regular updates to security systems to mitigate potential cyber threats.\n\nUser Rights & Cookies:\n• Participants and visitors reserve the right to inquire about, modify, or request deletion of their personal data from the platform according to regulatory guidelines.\n• The platform utilizes cookies to optimize system performance and safely personalize the browsing experience.";

        if ($doc) {
            $doc->update([
                'title_ar' => 'سياسة الخصوصية وحماية البيانات الشخصية',
                'title_fr' => 'Politique de Confidentialité & Protection des Données',
                'title_en' => 'Privacy Policy & Data Security',
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
                'fr' => 'Politique de Confidentialité & Protection des Données',
                'en' => 'Privacy Policy & Data Security',
                default => 'سياسة الخصوصية وحماية البيانات الشخصية',
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
        return view('livewire.public.privacy');
    }
}
