<?php

namespace SaasReady\Tests\Unit\Services\TranslationRepositories;

use Illuminate\Support\Facades\Cache;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Translation;
use SaasReady\Services\TranslationRepositories\CacheTranslationRepository;
use SaasReady\Tests\TestCase;

class CacheTranslationRepositoryTest extends TestCase
{
    public function testGetTranslationsFromCache()
    {
        $this->app->setLocale(LanguageCode::ENGLISH->value);
        Translation::factory()->count(2)
            ->sequence(
                [
                    'key' => 'hello-world',
                    'translations' => [
                        LanguageCode::ENGLISH->value => 'Hello World',
                    ],
                ],
                [
                    'key' => 'how-are-you',
                    'translations' => [
                        LanguageCode::ENGLISH->value => 'How are you?',
                    ],
                ]
            )->create();

        $repo = $this->app->make(CacheTranslationRepository::class);

        $this->assertSame('Hello World', $repo->getTranslation('hello-world'));
        $this->assertSame('How are you?', $repo->getTranslation('how-are-you'));

        Cache::has('saas-ready-cache-translations-en');
        $this->assertCount(2, Cache::get('saas-ready-cache-translations-en'));
        $this->assertArrayHasKey('hello-world', Cache::get('saas-ready-cache-translations-en'));
        $this->assertArrayHasKey('how-are-you', Cache::get('saas-ready-cache-translations-en'));
    }
}
