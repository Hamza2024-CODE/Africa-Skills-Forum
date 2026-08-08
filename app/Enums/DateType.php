<?php

namespace App\Enums;

enum DateType: string
{
    case REGISTRATION = 'REGISTRATION';
    case INSTITUTIONAL_SELECTION = 'INSTITUTIONAL_SELECTION';
    case WILAYA_COMPETITION = 'WILAYA_COMPETITION';
    case REGIONAL_COMPETITION = 'REGIONAL_COMPETITION';
    case NATIONAL_FINAL = 'NATIONAL_FINAL';
    case DOCUMENT_DEADLINE = 'DOCUMENT_DEADLINE';
    case EQUIPMENT_DEADLINE = 'EQUIPMENT_DEADLINE';

    public function label(): string
    {
        return match($this) {
            self::REGISTRATION => 'فترة التسجيلات',
            self::INSTITUTIONAL_SELECTION => 'فترة التصفيات المؤسساتية',
            self::WILAYA_COMPETITION => 'فترة المسابقات الولائية',
            self::REGIONAL_COMPETITION => 'فترة المسابقات الجهوية',
            self::NATIONAL_FINAL => 'فترة النهائيات الوطنية',
            self::DOCUMENT_DEADLINE => 'الآجل النهائي لرفع الوثائق',
            self::EQUIPMENT_DEADLINE => 'الآجل النهائي لاستلام التجهيزات',
        };
    }
}
