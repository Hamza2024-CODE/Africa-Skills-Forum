<?php

namespace App\Enums;

enum AssignmentType: string
{
    case JUDGE = 'JUDGE';
    case EXPERT = 'EXPERT';
    case OBSERVER = 'OBSERVER';

    public function label(): string
    {
        return match($this) {
            self::JUDGE => 'حكم رئيسي',
            self::EXPERT => 'خبير تقني',
            self::OBSERVER => 'ملاحظ مستقل',
        };
    }
}
