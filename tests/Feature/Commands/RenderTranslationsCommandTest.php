<?php

namespace SaasReady\Tests\Feature\Commands;

use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;
use SaasReady\Models\Translation;
use SaasReady\Tests\TestCase;

class RenderTranslationsCommandTest extends TestCase
{
    public function testCommandRendersTheTranslationFile()
    {
        Language::factory()->create([
            'code' => LanguageCode::ENGLISH,
            'activated_at' => now(),
        ]);
        Translation::factory()->count(2)
            ->sequence(
                [
                    'key' => 'seth',
                    'translations' => [
                        'en' => 'phat',
                    ],
                ],
                [
                    'key' => 'saas',
                    'translations' => [
                        'vi' => 'ready',
                    ],
                ]
            )->create();

        $this->app->useLangPath(sys_get_temp_dir());

        $this->artisan('saas-ready:render-translation en')
            ->expectsOutputToContain('exported successfully')
            ->execute();

        $this->assertTrue(file_exists(sys_get_temp_dir() . '/en.json'));

        $fileContentArr = json_decode(file_get_contents(sys_get_temp_dir() . '/en.json'), true);

        $this->assertArrayHasKey('seth', $fileContentArr);
        $this->assertArrayHasKey('saas', $fileContentArr);

        $this->assertSame('phat', $fileContentArr['seth']);
        $this->assertSame('', $fileContentArr['saas']);
    }

    public function testCommandWontRunBecauseLanguageDoesNotExists()
    {
        $this->artisan('saas-ready:render-translation vi')
            ->expectsOutputToContain('Language not found or not activated')
            ->execute();
    }

    public function testCommandWontRunBecauseLanguageDoesNotActivated()
    {
        Language::factory()->create([
            'code' => LanguageCode::VIETNAMESE,
            'activated_at' => null,
        ]);

        $this->artisan('saas-ready:render-translation vi')
            ->expectsOutputToContain('Language not found or not activated')
            ->execute();
    }
}
