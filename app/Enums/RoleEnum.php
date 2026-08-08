<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case NATIONAL_ADMIN = 'NATIONAL_ADMIN';
    case MEDIA_MANAGER = 'MEDIA_MANAGER';
    case COUNTRY_ADMIN = 'COUNTRY_ADMIN';
    case REGIONAL_ADMIN = 'REGIONAL_ADMIN';
    case WILAYA_ADMIN = 'WILAYA_ADMIN';
    case ORGANIZATION_ADMIN = 'ORGANIZATION_ADMIN';
    case COMPETITION_MANAGER = 'COMPETITION_MANAGER';
    case JUDGE = 'JUDGE';
    case EXPERT = 'EXPERT';
    case SPONSOR = 'SPONSOR';
    case EXECUTIVE_VIEWER = 'EXECUTIVE_VIEWER';
    case PARTICIPANT = 'PARTICIPANT';

    public function label(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Administrator',
            self::NATIONAL_ADMIN => 'National Administrator',
            self::MEDIA_MANAGER => 'Media & Content Manager',
            self::COUNTRY_ADMIN => 'Country Administrator',
            self::REGIONAL_ADMIN => 'Regional Administrator',
            self::WILAYA_ADMIN => 'Wilaya Administrator',
            self::ORGANIZATION_ADMIN => 'Organization Administrator',
            self::COMPETITION_MANAGER => 'Competition Manager',
            self::JUDGE => 'Judge',
            self::EXPERT => 'Expert',
            self::SPONSOR => 'Official Sponsor Partner',
            self::EXECUTIVE_VIEWER => 'Executive Read-Only Viewer',
            self::PARTICIPANT => 'Participant Competitor',
        };
    }
}
