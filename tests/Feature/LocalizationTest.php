<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_trilingual_and_portuguese_locale_switching(): void
    {
        foreach (['ar', 'fr', 'en', 'pt'] as $locale) {
            $response = $this->get("/lang/{$locale}");
            $response->assertSessionHas('locale', $locale);
        }
    }
}
