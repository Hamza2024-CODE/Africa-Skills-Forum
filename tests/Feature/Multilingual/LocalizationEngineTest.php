<?php

namespace Tests\Feature\Multilingual;

use App\Models\Skill;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizationEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_default_locale_is_arabic_and_dir_is_rtl(): void
    {
        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/?lang=ar');
        $response->assertStatus(200);
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
    }

    public function test_switching_locale_to_french_changes_dir_to_ltr(): void
    {
        $response = $this->get('/?lang=fr');
        $response->assertStatus(200);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee('lang="fr"', false);
        $response->assertSee('Accueil');
    }

    public function test_switching_locale_to_english_changes_dir_to_ltr(): void
    {
        $response = $this->get('/?lang=en');
        $response->assertStatus(200);
        $response->assertSee('dir="ltr"', false);
        $response->assertSee('lang="en"', false);
        $response->assertSee('Home');
    }

    public function test_model_has_translations_trait_retrieves_correct_localized_field(): void
    {
        $skill = Skill::first();
        $this->assertNotNull($skill);

        app()->setLocale('ar');
        $this->assertEquals($skill->name_ar, $skill->getLocalized('name'));

        app()->setLocale('fr');
        $this->assertEquals($skill->name_fr, $skill->getLocalized('name'));

        app()->setLocale('en');
        $this->assertEquals($skill->name_en, $skill->getLocalized('name'));
    }

    public function test_missing_translation_fallback_chain_works(): void
    {
        $skill = Skill::create([
            'code' => 'SKILL-TEST',
            'name_ar' => 'اختبار مهارة',
            'name_en' => 'Test Skill',
            'name_fr' => '', // Empty French name
            'is_active' => true,
        ]);

        app()->setLocale('fr');
        // French name is empty, fallback should pick English first
        $this->assertEquals('Test Skill', $skill->getLocalized('name'));
    }

    public function test_authenticated_user_language_switch_persists_to_db_and_session(): void
    {
        $user = \App\Models\User::first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->post('/lang/fr');
        $response->assertRedirect();
        
        $this->assertEquals('fr', session('locale'));
        $this->assertEquals('fr', $user->fresh()->locale);
    }

    public function test_post_language_switch_with_valid_locales(): void
    {
        $user = \App\Models\User::first();

        foreach (['ar', 'fr', 'en'] as $locale) {
            $response = $this->actingAs($user)->post("/lang/{$locale}");
            $response->assertRedirect();
            $this->assertEquals($locale, session('locale'));
            $this->assertEquals($locale, $user->fresh()->locale);
        }
    }

    public function test_invalid_locale_switch_is_ignored(): void
    {
        session()->put('locale', 'ar');
        $user = \App\Models\User::first();
        $user->update(['locale' => 'ar']);

        $response = $this->actingAs($user)->post('/lang/invalid_lang');
        $response->assertRedirect();

        $this->assertEquals('ar', session('locale'));
        $this->assertEquals('ar', $user->fresh()->locale);
    }

    public function test_guest_user_language_switch_updates_session(): void
    {
        $response = $this->post('/lang/en');
        $response->assertRedirect();

        $this->assertEquals('en', session('locale'));
    }
}
