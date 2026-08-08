<?php

namespace App\Enums;

enum ProvidedByEnum: string
{
    case ORGANIZER = 'ORGANIZER';
    case COUNTRY = 'COUNTRY';
    case ORGANIZATION = 'ORGANIZATION';
    case PARTICIPANT = 'PARTICIPANT';
    case SPONSOR = 'SPONSOR';

    public function label(): string
    {
        return match($this) {
            self::ORGANIZER => 'Organizing Committee',
            self::COUNTRY => 'Participating Country',
            self::ORGANIZATION => 'Vocational Institute',
            self::PARTICIPANT => 'Participant Competitor',
            self::SPONSOR => 'Official Sponsor Partner',
        };
    }
}
