<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Organization;
use App\Models\Wilaya;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationsFromSigSeeder extends Seeder
{
    /**
     * استيراد بيانات المؤسسات من نظام SIG (جدول etablissement)
     * type mapping: 1=وزارة, 4=IFEP, 5=DFEP, 6=INSFP, 8=CFPA, 9=CFPPA
     */
    public function run(): void
    {
        $algerie = Country::where('iso2', 'DZ')->first();
        if (!$algerie) {
            $this->command->error('Algeria not found in countries table. Run GeographySeeder first.');
            return;
        }

        $typeMap = [
            1 => 'ministry',
            4 => 'ifep',
            5 => 'dfep',
            6 => 'insfp',
            8 => 'cfpa',
            9 => 'cfppa',
        ];

        $etablissements = $this->getData();
        $inserted = 0;
        $skipped  = 0;

        foreach ($etablissements as $e) {
            // Skip if already exists by code
            if (Organization::where('code', $e['code'])->exists()) {
                $skipped++;
                continue;
            }

            // Resolve wilaya by code (2-digit prefix of wilaya_code field)
            $wilayaModel = null;
            if (!empty($e['wilaya_code'])) {
                $wCode = intval($e['wilaya_code']);
                $wilayaModel = Wilaya::where('code', $wCode)->first();
            }

            Organization::create([
                'uuid'       => Str::uuid(),
                'code'       => $e['code'],
                'name_ar'    => $e['name_ar'],
                'name_fr'    => $e['name_fr'],
                'name_en'    => null,
                'type'       => $typeMap[$e['type']] ?? 'cfpa',
                'country_id' => $algerie->id,
                'wilaya_id'  => $wilayaModel?->id,
                'email'      => $e['email'] ?? null,
                'phone'      => $e['phone'] ?? null,
                'address'    => $e['address_ar'] ?? null,
                'is_active'  => true,
            ]);
            $inserted++;
        }

        $this->command->info("OrganizationsFromSigSeeder: {$inserted} inserted, {$skipped} skipped (already exist).");
    }

    private function getData(): array
    {
        return [
            ['code' => '2606', 'wilaya_code' => 26, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين عين بوسيف', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage AIN BOUCIF", 'phone' => '025701149', 'email' => 'ainboucifcfpa@gmail.com', 'address_ar' => 'حي بوشهير الطاهر عين بوسيف المدية'],
            ['code' => '06/17', 'wilaya_code' => 17, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين في عين الابل', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage AIN ELIBEL", 'phone' => '027899119', 'email' => 'ainelibelcfpa@gmail.com', 'address_ar' => 'شارع الاستقلال بلدية عين الابل'],
            ['code' => '09-17', 'wilaya_code' => 17, 'type' => 8, 'name_ar' => 'مركز التكوين المهني والتمهين إناث عين وسارة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage FEMININ AIN OUESSARA", 'phone' => '027945367', 'email' => 'cfpafeminin17@gmail.com', 'address_ar' => 'حي زيغود يوسف عين وسارة ولاية الجلفة'],
            ['code' => '03/17', 'wilaya_code' => 17, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين عين وسارة', 'name_fr' => "centre de formation professionnelle et d'apprentissage Allim Yahia Ain Oussera", 'phone' => '027807180', 'email' => 'cfpagarcon17@gmail.com', 'address_ar' => 'طريق الوطني رقم 01 عين وسارة الجلفة'],
            ['code' => '74-1606', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين باب الواد إناث', 'name_fr' => "Centre de Formation Professionnelle et d'Apprentissage FEMININ BAB EL OUED", 'phone' => '020295169', 'email' => 'cfpababelouedf@hotmail.com', 'address_ar' => '28 شارع رشيد كواش باب الوادي'],
            ['code' => '1605', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بولوغين إبن زيري', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BOLOGHINE IBNOU ZIRI", 'phone' => '023154552', 'email' => 'cfpabologhineg@hotmail.com', 'address_ar' => '29 نهج على أوراق السيدة الافريقية بولوغين الجزائر'],
            ['code' => '56-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين أوريدة مداد (القصبة)', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage OURIDA MEDDAD", 'phone' => '023409790', 'email' => 'cfpaouridameddad@hotmail.com', 'address_ar' => '09 شارع أوريدة مداد القصبة الجزائر'],
            ['code' => '07-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين باب الوادي ذكور', 'name_fr' => "Centre de Formation Professionnelle de BAB EL OUED GARCONS", 'phone' => '023159653', 'email' => 'cfpababelouedgarcon@gmail.com', 'address_ar' => '53 شارع عبد الرحمان سالم واد قريش'],
            ['code' => '932-1610', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين براقي', 'name_fr' => "C.F.P.A BARAKI", 'phone' => '023903760', 'email' => 'cfpabaraki@hotmail.fr', 'address_ar' => '115 طريق الاربعاء مركز التكوين المهني و التمهين براقي'],
            ['code' => '16/18', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين الكاليتوس', 'name_fr' => "CFPA DES EUCALIPTUS", 'phone' => '044986900', 'email' => 'cfpaeucalyptus@hotmail.com', 'address_ar' => '11 الطريق الولائي شارع بيلو الكاليتوس'],
            ['code' => '16/40', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين سيدي موسى', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage SIDI MOUSSA", 'phone' => '028448004', 'email' => 'sidimoussacfpatracking@gmail.com', 'address_ar' => 'حي المكتوب سيدي موسى'],
            ['code' => '26-03', 'wilaya_code' => 26, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بني سليمان', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BENI SLIMANE", 'phone' => '025714361', 'email' => 'benislimanecfpa2022@gmail.com', 'address_ar' => 'مركز التكوين المهني والتمهين الشهيد بوسطة صالح بني سليمان المدية'],
            ['code' => '2610', 'wilaya_code' => 26, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين البرواقية', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BERROUAGUIA", 'phone' => '044564726', 'email' => 'cfpaberroughiamedea@gmail.com', 'address_ar' => 'حي أول نوفمبر 1954 البرواقية المدية'],
            ['code' => '1646', 'wilaya_code' => 16, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في الصناعات و الفنون المطبعية', 'name_fr' => "INSFP de bir mourad rais", 'phone' => '023545371', 'email' => null, 'address_ar' => 'نهج القنادييس الفوج رقم 03 بئر مراد رايس'],
            ['code' => '1652', 'wilaya_code' => 16, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في التكوين المهني للتبريد بئرمراد رايس', 'name_fr' => "Institut National Spécialisé de la Formation Professionnelle FROID BIR MOURAD RAIS", 'phone' => '023540030', 'email' => 'insfpfroid@hotmail.com', 'address_ar' => '22 نهج سليمان عميرات بئرمرادرايس الجزائر'],
            ['code' => '16/16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بئرخادم ذكور', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BIRKHADEM GARCONS", 'phone' => '023545712', 'email' => 'cfpabirkhadem.g@gmail.com', 'address_ar' => 'طريق سوامي زونكة بئر خادم الجزائر'],
            ['code' => '16/44', 'wilaya_code' => 16, 'type' => 4, 'name_ar' => 'معهد التكوين و التعليم المهنيين بئرخادم', 'name_fr' => "IFEP BIRKHADEM", 'phone' => '023542144', 'email' => 'ifpdgbirkhadem@gmail.com', 'address_ar' => 'شارع الاخوة الثلاث جيلالي بئر خادم الجزائر'],
            ['code' => '1645', 'wilaya_code' => 16, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في التكوين المهني الفتح بئر خادم', 'name_fr' => "Institut National Spécialisé de la Formation Professionnelle EL FeTH birkhadem", 'phone' => '020057624', 'email' => 'insfpelfeth@hotmail.com', 'address_ar' => '3 شارع الإخوة جيلالي بئر خادم'],
            ['code' => '16/12', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين جسر قسنطينة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage GUE DE CONSTANTINE", 'phone' => '023613438', 'email' => 'cfpagc_hamraoui@hotmail.com', 'address_ar' => '14 الطريق الولائي جسر قسنطينة الجزائر'],
            ['code' => '16/27', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين عين النعجة', 'name_fr' => "CFPA de AIN NAADJA", 'phone' => '028156833', 'email' => 'cfpaainnaadja@outlook.com', 'address_ar' => 'المنطقة السكنية الحضرية الجديدة عين النعجة'],
            ['code' => '16-42', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين سحاولة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage SAOULA", 'phone' => '023338133', 'email' => 'cfpasaoula1642@hotmail.com', 'address_ar' => 'طريق الدويرة السحاولة'],
            ['code' => '17-08', 'wilaya_code' => 17, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بالبيرين', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BIRINE", 'phone' => '027800151', 'email' => 'cfpabirine17@gmail.com', 'address_ar' => 'طريق حد الصحاري بالبيرين الجلفة 17014'],
            ['code' => '53-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بئرتوتة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BIRTOUTA", 'phone' => '023400524', 'email' => 'cfpabirtouta4@gmail.com', 'address_ar' => 'حي علي بوحجة بئر توتة'],
            ['code' => '11-29', 'wilaya_code' => 29, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين سيدي سليمان بوحنيفية', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage SIDI SLIMANE BOUHANIFIA", 'phone' => '045765107', 'email' => 'cfpabouhanifia@gmail.com', 'address_ar' => 'دوار سيدي سليمان بوحنيفية'],
            ['code' => '1602', 'wilaya_code' => 16, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في التكوين المهني لبن عكنون', 'name_fr' => "Institut National Spécialisé de la Formation Professionnelle BEN AKNOUN Alger", 'phone' => '023384064', 'email' => 'inhrtbenak@gmail.com', 'address_ar' => 'الحوضين بن عكنون'],
            ['code' => 'MFEP', 'wilaya_code' => null, 'type' => 1, 'name_ar' => 'وزارة التكوين و التعليم المهنيين', 'name_fr' => "MFEP", 'phone' => '023255266', 'email' => 'contact-at@mfep.gov.dz', 'address_ar' => 'شارع الاخوة عيسو بن عكنون ولاية الجزائر'],
            ['code' => '25-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بني مسوس', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BENI MESSOUS", 'phone' => '023130408', 'email' => 'cfpa.benimessous@gmail.com', 'address_ar' => 'رقم 45 طريق المستشفى بني مسوس'],
            ['code' => '08-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بوزريعة 01', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage POLYVALENT BOUZAREAH 01", 'phone' => '020286465', 'email' => 'cfpabouzareah1@gmail.com', 'address_ar' => 'حي تافدائيين بئر زواف بوزريعة'],
            ['code' => '14-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بوزريعة 02', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BOUZAREAH 02", 'phone' => '023250763', 'email' => 'cfpabouzareah2@hotmail.fr', 'address_ar' => 'حي المقام الجميل بوزريعة 2'],
            ['code' => '15-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بوزريعة إناث', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BOUZAREAH FEMININ", 'phone' => '020286058', 'email' => 'cfpabouzareah3@hotmail.com', 'address_ar' => 'طريق بينام حي العشيرة بوزريعة'],
            ['code' => '17/11', 'wilaya_code' => 17, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين الشارف', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage CHAREF", 'phone' => '027843735', 'email' => 'cfpacharef17@gmail.com', 'address_ar' => 'حي الوئام طريق الجلفة بلدية الشارف الجلفة'],
            ['code' => '26-09', 'wilaya_code' => 26, 'type' => 8, 'name_ar' => 'مركـز التكويـن المهنـي والتمهيـن بشلالـة العـذاورة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage CHELLALET EL ADHAOURA", 'phone' => '025751410', 'email' => 'cfpacea26@gmail.com', 'address_ar' => 'حي القدس شلالة العذاورة ولاية المدية'],
            ['code' => '42-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين عين البنيان', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage AIN BENIAN", 'phone' => '023398376', 'email' => 'cfpaainbenian2023@gmail.com', 'address_ar' => 'الطريق الوطني رقم 11 عين بنيان'],
            ['code' => '16/38', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين شراقة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage CHERAGA", 'phone' => '023365036', 'email' => 'cfpacheraga@outlook.com', 'address_ar' => '142 طريق اولاد فايت الشراقة'],
            ['code' => '16/26', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بولوغين إناث (حمام الرومان)', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage BOLOGHINE FEMININ", 'phone' => '023063061', 'email' => 'cfpabainem@hotmail.com', 'address_ar' => 'الطريق الوطني رقم 11 بولوغين-ابن زيري'],
            ['code' => '41-16', 'wilaya_code' => 16, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بلمين ارزقي أولادفايت', 'name_fr' => "Centre de Formation Professionnelle et d'Apprentissage belamine arezki OULED FAYET", 'phone' => '020278167', 'email' => 'cfpaouledfayet1641@gmail.com', 'address_ar' => 'طريق بوشاوي اولاد فايت'],
            ['code' => '16/51', 'wilaya_code' => 16, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في التكوين المهني أولادفايت', 'name_fr' => "Institut National Spécialisé de la Formation Professionnelle OULED FAYET", 'phone' => '020314570', 'email' => 'insfp.of@gmail.com', 'address_ar' => 'طريق بلاطو اولاد فايت'],
            ['code' => '25-01', 'wilaya_code' => 25, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين متعدد الأقسام قسنطينة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage POLYVALENT CONSTANTINE", 'phone' => '031886824', 'email' => 'cfpaahmedboudermine@gmail.com', 'address_ar' => 'رقم 02 نهج محمد لوصيف قسنطينة'],
            ['code' => '25-02', 'wilaya_code' => 25, 'type' => 6, 'name_ar' => 'المعهد الوطني المتخصص في التكوين المهني سيدي مبروك', 'name_fr' => "Institut National Spécialisé de Formation Professionnelle SIDI MABROUK", 'phone' => '030336953', 'email' => 'insfpsidimabbrouk.2502@gmail.com', 'address_ar' => '27 حي بن خباب سيدي مبروك قسنطينة'],
            ['code' => '25-03', 'wilaya_code' => 25, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين للبنات قسنطينة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage FIMENIN", 'phone' => '031936927', 'email' => 'cfpabellevue.2503@gmail.com', 'address_ar' => 'رقم 98 شارع باستور ممتد المنظر الجميل 25000'],
            ['code' => '25-09', 'wilaya_code' => 25, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين عين الباي', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage AIN EL BEY", 'phone' => '031725671', 'email' => 'cfpa.ziadia.2509@gmail.com', 'address_ar' => 'طريق جبل الوحش الزيادية قسنطينة'],
            ['code' => '25-12', 'wilaya_code' => 25, 'type' => 8, 'name_ar' => 'مركز التكوين المهني و التمهين بالما قسنطينة', 'name_fr' => "Centre de Formation Professionnelle et de l'Apprentissage PALMA", 'phone' => '031606516', 'email' => 'cfpapalma.2512chaoui@gmail.com', 'address_ar' => 'المنطقة الصناعية بالما قسنطينة'],
            ['code' => '25-00-DFEP', 'wilaya_code' => 25, 'type' => 5, 'name_ar' => 'مديرية التكوين والتعليم المهنيين لولاية قسنطينة', 'name_fr' => "Direction de la Formation et de l'Enseignement Professionnels de Constantine", 'phone' => '030318336', 'email' => 'dfepconstantine-at@mfep.gov.dz', 'address_ar' => 'طريق ماسينيسا المنطقة الصناعية بالما قسنطينة'],
        ];
    }
}
