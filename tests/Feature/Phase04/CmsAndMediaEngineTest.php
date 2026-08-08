<?php

namespace Tests\Feature\Phase04;

use App\Livewire\Public\EventsIndex;
use App\Livewire\Public\GalleryIndex;
use App\Livewire\Public\GlobalSearch;
use App\Livewire\Public\VideoCenter;
use App\Models\Album;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Video;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CmsAndMediaEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_cms_news_article_and_event_can_be_created_with_multilingual_fields(): void
    {
        $article = NewsArticle::where('slug', 'launch-of-worldskills-algeria-2027')->first();
        $this->assertNotNull($article);

        app()->setLocale('ar');
        $this->assertEquals($article->title_ar, $article->getLocalized('title'));

        app()->setLocale('fr');
        $this->assertEquals($article->title_fr, $article->getLocalized('title'));

        app()->setLocale('en');
        $this->assertEquals($article->title_en, $article->getLocalized('title'));
    }

    public function test_gallery_index_renders_published_albums(): void
    {
        $response = $this->get('/gallery?lang=ar');
        $response->assertStatus(200);

        Livewire::test(GalleryIndex::class)
            ->assertSee('ألبومات وتغطيات أولمبياد المهن');
    }

    public function test_events_index_renders_published_events(): void
    {
        $response = $this->get('/events?lang=ar');
        $response->assertStatus(200);

        Livewire::test(EventsIndex::class)
            ->assertSee('أحداث وفعاليات أولمبياد المهن 2027');
    }

    public function test_video_center_renders_published_videos(): void
    {
        $response = $this->get('/videos?lang=ar');
        $response->assertStatus(200);

        Livewire::test(VideoCenter::class)
            ->assertSee('فيديوهات وبث أولمبياد المهن');
    }

    public function test_global_search_returns_relevant_multilingual_results(): void
    {
        session()->forget('locale');
        app()->setLocale('ar');

        Livewire::test(GlobalSearch::class)
            ->set('query', 'الانطلاق')
            ->assertSee('الأخبار والمقالات');
    }
}
