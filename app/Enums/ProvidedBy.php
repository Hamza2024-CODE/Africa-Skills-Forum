<?php

namespace App\Enums;

enum ProvidedBy: string
{
    case ORGANIZER = 'ORGANIZER';
    case COUNTRY = 'COUNTRY';
    case PARTICIPANT = 'PARTICIPANT';
    case SPONSOR = 'SPONSOR';

    public function label(): string
    {
        return match($this) {
            self::ORGANIZER => 'المنظم المركزي',
            self::COUNTRY => 'الدولة المشاركة',
            self::PARTICIPANT => 'المشارك نفسه',
            self::SPONSOR => 'الراعي / الشريك',
        };
    }
}
