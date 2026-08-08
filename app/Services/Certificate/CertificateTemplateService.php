<?php

namespace App\Services\Certificate;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class CertificateTemplateService
{
    /**
     * Resolve template configuration for given certificate type.
     */
    public function getTemplateConfig(string $type): array
    {
        $normalizedType = strtoupper($type);

        $mappedType = match ($normalizedType) {
            'PARTICIPANT', 'PARTICIPATION' => 'PARTICIPATION',
            'PARTNER', 'ECONOMIC_PARTNER'  => 'PARTNER',
            default                        => 'APPRECIATION',
        };

        $config = Config::get("certificates.templates.{$mappedType}");

        if (!$config) {
            $config = Config::get('certificates.templates.APPRECIATION');
        }

        return $config;
    }

    /**
     * Validate SHA-256 integrity of template background file.
     */
    public function verifyIntegrity(string $type): bool
    {
        $config = $this->getTemplateConfig($type);
        $filePath = public_path($config['background']);

        if (!File::exists($filePath)) {
            return false;
        }

        $currentHash = strtoupper(hash_file('sha256', $filePath));
        return $currentHash === strtoupper($config['sha256']);
    }
}
