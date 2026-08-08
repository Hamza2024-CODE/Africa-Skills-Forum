<?php

namespace App\Services\Venue;

use App\Models\VenuePoiType;

class VenueIconRegistryService
{
    /**
     * Predefined Lucide SVG Icon definitions for core operational types.
     */
    protected array $standardIcons = [
        'SKILL' => [
            'icon_name' => 'trophy',
            'name_ar'   => 'منافسة المهارات',
            'name_fr'   => 'Compétition des Métiers',
            'name_en'   => 'Skill Competition',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9H4.5a2.5 2.5 0 010-5H6M18 9h1.5a2.5 2.5 0 000-5H18M4 22h16M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22M14 14.66V17c0 .55.47.98.97 1.21 1.18.54 2.03 2.03 2.03 3.79M18 2H6v7a6 6 0 0012 0V2z"/></svg>',
            'primary_color_hex' => '#D97706',
            'bg_color_hex'      => '#FEF3C7',
        ],
        'RESTAURANT' => [
            'icon_name' => 'utensils',
            'name_ar'   => 'المطعم والإطعام',
            'name_fr'   => 'Restauration',
            'name_en'   => 'Dining & Catering',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 2v20M6 2v6a3 3 0 003 3v11M12 2v20M15 2v6a3 3 0 003 3v11"/></svg>',
            'primary_color_hex' => '#059669',
            'bg_color_hex'      => '#D1FAE5',
        ],
        'ACCOMMODATION' => [
            'icon_name' => 'hotel',
            'name_ar'   => 'الإقامة والسكن',
            'name_fr'   => 'Hébergement',
            'name_en'   => 'Accommodation',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"/></svg>',
            'primary_color_hex' => '#7C3AED',
            'bg_color_hex'      => '#EDE9FE',
        ],
        'TRANSPORT_STATION' => [
            'icon_name' => 'bus',
            'name_ar'   => 'محطة النقل بالحافلات',
            'name_fr'   => 'Station de Transport',
            'name_en'   => 'Transport Station',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-3M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2M8 6h8m-9 9h.01M17 15h.01"/></svg>',
            'primary_color_hex' => '#0284C7',
            'bg_color_hex'      => '#E0F2FE',
        ],
        'MEDICAL_POINT' => [
            'icon_name' => 'hospital',
            'name_ar'   => 'المركز الطبي والإسعاف',
            'name_fr'   => 'Centre Médical',
            'name_en'   => 'Medical Center',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m6-10h2m-1-1v2m-6 9h12"/></svg>',
            'primary_color_hex' => '#E11D48',
            'bg_color_hex'      => '#FFE4E6',
        ],
        'MEETING' => [
            'icon_name' => 'presentation',
            'name_ar'   => 'قاعة الاجتماعات التقنية',
            'name_fr'   => 'Réunions Techniques',
            'name_en'   => 'Technical Meetings',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4v10a2 2 0 002 2h12a2 2 0 002-2V4"/></svg>',
            'primary_color_hex' => '#EA580C',
            'bg_color_hex'      => '#FFEDD5',
        ],
        'SECURITY_ZONE' => [
            'icon_name' => 'shield-check',
            'name_ar'   => 'منطقة تفتيش وأمن',
            'name_fr'   => 'Zone de Sécurité',
            'name_en'   => 'Security Zone',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
            'primary_color_hex' => '#475569',
            'bg_color_hex'      => '#F1F5F9',
        ],
        'INFO_DESK' => [
            'icon_name' => 'info',
            'name_ar'   => 'مكتب الاستعلامات والوفود',
            'name_fr'   => 'Point d\'Information',
            'name_en'   => 'Information Desk',
            'svg_raw'   => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'primary_color_hex' => '#2563EB',
            'bg_color_hex'      => '#DBEAFE',
        ],
    ];

    /**
     * Ensure standard SVG icon POI types are seeded in database without Emojis.
     */
    public function seedStandardTypes(): void
    {
        foreach ($this->standardIcons as $typeKey => $data) {
            VenuePoiType::firstOrCreate(
                ['type_key' => $typeKey],
                [
                    'name_ar'             => $data['name_ar'],
                    'name_fr'             => $data['name_fr'],
                    'name_en'             => $data['name_en'],
                    'icon_name'           => $data['icon_name'],
                    'svg_raw'             => $data['svg_raw'],
                    'primary_color_hex'   => $data['primary_color_hex'],
                    'bg_color_hex'        => $data['bg_color_hex'],
                    'marker_style_preset' => 'glass_floating_badge',
                    'is_active'           => true,
                ]
            );
        }
    }

    /**
     * Get SVG content for a POI type key.
     */
    public function getSvgIcon(string $typeKey): string
    {
        $type = VenuePoiType::where('type_key', strtoupper($typeKey))->first();

        if ($type && !empty($type->svg_raw)) {
            return $type->svg_raw;
        }

        $fallback = $this->standardIcons[strtoupper($typeKey)]['svg_raw'] ?? null;
        if ($fallback) {
            return $fallback;
        }

        return '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>';
    }

    /**
     * Verify string contains NO Emojis (No-Emoji Design Enforcement).
     */
    public function validateNoEmoji(string $text): bool
    {
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';
        return preg_match($regexEmoticons, $text) === 0;
    }
}
