<?php

namespace SaasReady\Tests\Unit\Services\TranslationRepositories;

use ReflectionProperty;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Translation;
use SaasReady\Services\TranslationRepositories\DatabaseTranslationRepository;
use SaasReady\Tests\TestCase;

class DatabaseTranslationRepositoryTest extends TestCase
{
    public function testGetTranslationSingleModeOnlyLoadOneTranslation()
    {
        config(['saas-ready.translation.strategy' => 'single']);
        app()->setLocale(LanguageCode::ENGLISH->value);

        $repo = $this->app->make(DatabaseTranslationRepository::class);

        $reflectorProp = new ReflectionProperty($repo, 'translations');
        $reflectorProp->setAccessible(true);

        Translation::factory()->create([
            'key' => 'hello-world',
            'translations' => [
                LanguageCode::ENGLISH->value => $translationText = 'Hello World',
            ],
        ]);

        $text = $repo->getTranslation('hello-world');

        $this->assertSame($translationText, $text);

        $translations = $reflectorProp->getValue($repo);
        $this->assertCount(1, $translations);
        $this->assertArrayHasKey('hello-world', $translations);
    }

    public function testGetTranslationSingleModeNoneExistenceWillUseTheKeyByDefault()
    {
        config(['saas-ready.translation.strategy' => 'single']);
        app()->setLocale(LanguageCode::ENGLISH->value);

        $repo = $this->app->make(DatabaseTranslationRepository::class);

        $reflectorProp = new ReflectionProperty($repo, 'translations');
        $reflectorProp->setAccessible(true);

        $text = $repo->getTranslation('seth-phat-nek');

        $this->assertSame('seth-phat-nek', $text);

        $translations = $reflectorProp->getValue($repo);
        $this->assertCount(1, $translations);
        $this->assertArrayHasKey('seth-phat-nek', $translations);
    }

    public function testGetTranslationAllModeWillLoadAllTranslationThenReturnTheValue()
    {
        config(['saas-ready.translation.strategy' => 'all']);
        app()->setLocale(LanguageCode::ENGLISH->value);

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

        $repo = $this->app->make(DatabaseTranslationRepository::class);

        $this->assertSame('Hello World', $repo->getTranslation('hello-world'));
        $this->assertSame('How are you?', $repo->getTranslation('how-are-you'));

        $reflectorProp = new ReflectionProperty($repo, 'translations');
        $reflectorProp->setAccessible(true);
        $translations = $reflectorProp->getValue($repo);
        $this->assertCount(2, $translations);
        $this->assertArrayHasKey('hello-world', $translations);
        $this->assertArrayHasKey('how-are-you', $translations);

        // access with non-exists key would return the same key
        $this->assertSame('hello-world-abc', $repo->getTranslation('hello-world-abc'));
    }
}
