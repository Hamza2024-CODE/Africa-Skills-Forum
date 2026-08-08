<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Get localized attribute value with smart fallback chain:
     * Current Locale -> English -> Arabic -> First non-empty
     */
    public function getLocalized(string $field): string
    {
        $locale = App::getLocale();

        $currentKey = "{$field}_{$locale}";
        if (!empty($this->{$currentKey})) {
            return $this->{$currentKey};
        }

        // Fallback 1: English
        $enKey = "{$field}_en";
        if (!empty($this->{$enKey})) {
            return $this->{$enKey};
        }

        // Fallback 2: Arabic
        $arKey = "{$field}_ar";
        if (!empty($this->{$arKey})) {
            return $this->{$arKey};
        }

        // Fallback 3: French
        $frKey = "{$field}_fr";
        if (!empty($this->{$frKey})) {
            return $this->{$frKey};
        }

        return '';
    }
}
