<?php

namespace App\Livewire\Public;

use App\Services\SettingsEngine;
use Livewire\Component;

class Guide extends Component
{
    public array $forumData = [];

    public function mount(SettingsEngine $settings)
    {
        $locale = app()->getLocale();
        $this->forumData = [
            'name'             => $settings->get("forum.name_{$locale}") ?: polyTrans('منتدى السياسات الأفريقية للمهارات 2026', 'Forum des Politiques Africaines des Compétences 2026', 'Africa Skills Policy Forum 2026', 'Fórum de Políticas Africanas de Competências 2026'),
            'slogan'           => $settings->get("forum.slogan_{$locale}") ?: polyTrans("صياغة مستقبل المهارات، تمكين الشباب الأفريقي", "Façonner l'avenir des compétences, autonomiser la jeunesse africaine", "Shaping the Future of Skills, Empowering Africa's Youth", "Moldar o Futuro das Competências, Capacitar a Juventude Africana"),
            'dates'            => $settings->get("forum.dates_{$locale}") ?: polyTrans("16 - 18 نوفمبر 2026", "16 - 18 Novembre 2026", "16 - 18 November 2026", "16 - 18 de Novembro de 2026"),
            'principle'        => $settings->get("forum.principle_{$locale}") ?: polyTrans("مستقبل المهارات في إفريقيا يجب أن يُصاغ من قِبل الأفارقة أنفسهم.", "L'avenir des compétences en Afrique doit être façonné par les Africains eux-mêmes.", "Africa's skills future must be shaped by Africans.", "O futuro das competências em África deve ser moldado pelos próprios africanos."),
            'description'      => $settings->get("forum.description_{$locale}") ?: polyTrans(
                "يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي، ليكون الحدث السياسي الرفيع المستوى الرئيسي. يجمع المنتدى الوزراء الأفارقة المكلفين بالتكوين والتعليم المهنيين، إلى جانب الخبراء التقنيين والشركاء المؤسساتيين والدوليين، في برنامج عمل يقوم على الحوار الوزاري والتعاون القاري والالتزام السياسي المشترك.",
                "Le Forum des Politiques Africaines des Compétences est co-organisé par le Ministère de la Formation et de l'Enseignement Professionnels d'Algérie et la Commission de l'Union Africaine, constituant le principal événement politique de haut niveau.",
                "The African Skills Policy Forum is co-organized by Algeria's Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political summit.",
                "O Fórum de Políticas Africanas de Competências é coorganizado pelo Ministério da Formação e Ensino Profissionais da Argélia e pela Comissão da União Africana, constituindo a principal cimeira política de alto nível."
            ),
            'stat_countries'   => $settings->get('forum.stat_countries', '+30'),
            'stat_ministers'   => $settings->get('forum.stat_ministers', '+20'),
            'stat_roundtables' => $settings->get('forum.stat_roundtables', '2'),
            'stat_panels'      => $settings->get('forum.stat_panels', '5+'),
        ];
    }

    public function render()
    {
        return view('livewire.public.guide')->layout('components.layouts.public');
    }
}
