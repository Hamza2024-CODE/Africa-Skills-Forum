<?php

namespace App\Enums;

enum MemberType: string
{
    case MINISTERIAL_OBSERVER = 'MINISTERIAL_OBSERVER';
    case DELEGATION_HEAD = 'DELEGATION_HEAD';
    case PARTICIPANT   = 'PARTICIPANT';
    case EXPERT        = 'EXPERT';
    case JUDGE         = 'JUDGE';
    case PRESS         = 'PRESS';
    case SUPERVISOR    = 'SUPERVISOR';
    case VIP           = 'VIP';
    case DELEGATE      = 'DELEGATE';
    case OFFICIAL      = 'OFFICIAL';
    case SUPPORT_STAFF = 'SUPPORT_STAFF';

    public function label(): string
    {
        return match($this) {
            self::MINISTERIAL_OBSERVER => 'وزير / مراقب تنفيذي (Ministerial Executive Observer)',
            self::DELEGATION_HEAD => 'مسؤول الوفد (Head of Delegation)',
            self::PARTICIPANT   => 'متنافس (Competitor)',
            self::EXPERT        => 'خبير (Expert)',
            self::JUDGE         => 'حكم (Judge)',
            self::PRESS         => 'صحفي / إعلامي (Press / Media)',
            self::SUPERVISOR    => 'مؤطر / قائد فريق (Supervisor / Team Leader)',
            self::VIP           => 'شخصية مرموقة (VIP)',
            self::DELEGATE      => 'مندوب وفد (Delegate)',
            self::OFFICIAL      => 'مسؤول رسمي (Official)',
            self::SUPPORT_STAFF => 'طاقم دعم (Support Staff)',
        };
    }
}
