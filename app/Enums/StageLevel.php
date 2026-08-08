<?php

namespace App\Enums;

enum StageLevel: string
{
    case INSTITUTIONAL = 'INSTITUTIONAL';
    case WILAYA = 'WILAYA';
    case REGIONAL = 'REGIONAL';
    case NATIONAL_FINAL = 'NATIONAL_FINAL';

    public function label(): string
    {
        return match($this) {
            self::INSTITUTIONAL => 'الاختيارات على مستوى المؤسسات',
            self::WILAYA => 'المسابقات الولائية',
            self::REGIONAL => 'المسابقات الجهوية',
            self::NATIONAL_FINAL => 'النهائيات الوطنية',
        };
    }
}
