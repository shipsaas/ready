<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Support\Facades\Event;
use SaasReady\Constants\LanguageCode;
use SaasReady\Events\Language\LanguageCreated;
use SaasReady\Events\Language\LanguageDeleted;
use SaasReady\Events\Language\LanguageUpdated;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function testIndexEndpointReturnsAllLanguages()
    {
        $languages = Language::factory()->count(2)->sequence(
            [
                'code' => LanguageCode::ENGLISH,
            ],
            [
                'code' => LanguageCode::VIETNAMESE,
            ]
        )->create();

        $this->json('GET', 'saas/languages')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $languages[0]->uuid,
            ])
            ->assertJsonFragment([
                'uuid' => $languages[1]->uuid,
            ]);
    }

    public function testIndexEndpointReturnsActiveLanguages()
    {
        $languages = Language::factory()->count(2)->sequence(
            [
                'code' => LanguageCode::ENGLISH,
                'activated_at' => now(),
            ],
            [
                'code' => LanguageCode::GERMAN,
                'activated_at' => null,
            ]
        )->create();

        $this->json('GET', 'saas/languages', ['is_active' => 1])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $languages[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $languages[1]->uuid,
            ]);
    }


    public function testIndexEndpointReturnsPaginatedLanguages()
    {
        $languages = Language::factory()->count(2)->sequence(
            [
                'code' => LanguageCode::ENGLISH,
                'name' => 'English',
            ],
            [
                'code' => LanguageCode::VIETNAMESE,
                'name' => 'Vietnamese',
            ],
        )->create();

        $this->json('GET', 'saas/languages', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $languages[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $languages[1]->uuid,
            ]);

        $this->json('GET', 'saas/languages', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 2,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $languages[1]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $languages[0]->uuid,
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/languages/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointLanguageByUuid()
    {
        $currency = Language::factory()->create();

        $this->json('GET', 'saas/languages/' . $currency->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        Event::fake([LanguageCreated::class]);
        $this->travelTo('2022-10-23 10:00:59');

        $this->json('POST', 'saas/languages/', [
            'code' => LanguageCode::ENGLISH->value,
            'name' => 'English',
            'is_active' => true,
        ])->assertCreated();

        $this->assertDatabaseHas((new Language())->getTable(), [
            'code' => LanguageCode::ENGLISH->value,
            'name' => 'English',
            'activated_at' => '2022-10-23 10:00:59',
        ]);

        Event::assertDispatched(
            LanguageCreated::class,
            fn (LanguageCreated $event) => $event->language->code === LanguageCode::ENGLISH
                && $event->language->name === 'English'
        );
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        Event::fake([LanguageUpdated::class]);

        $language = Language::factory()->create([
            'code' => LanguageCode::ENGLISH->value,
            'name' => 'English',
            'activated_at' => now(),
        ]);

        $this->json('PUT', 'saas/languages/' . $language->uuid, [
            'code' => LanguageCode::VIETNAMESE->value,
            'name' => 'Vietnamese',
            'is_active' => false,
        ])->assertOk();

        $updatedLanguage = $language->fresh();

        $this->assertSame($language->id, $updatedLanguage->id);
        $this->assertNotSame($language->code, $updatedLanguage->code);
        $this->assertNotSame($language->name, $updatedLanguage->name);
        $this->assertNull($updatedLanguage->activated_at);

        $this->assertDatabaseMissing($language->getTable(), [
            'code' => LanguageCode::ENGLISH->value,
        ]);

        $this->assertDatabaseHas($language->getTable(), [
            'code' => LanguageCode::VIETNAMESE->value,
            'name' => 'Vietnamese',
        ]);

        Event::assertDispatched(
            LanguageUpdated::class,
            fn (LanguageUpdated $event) => $event->language->code === LanguageCode::VIETNAMESE
                && $event->language->name === 'Vietnamese'
                && $event->language->is($language)
        );
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        Event::fake([LanguageDeleted::class]);

        $language = Language::factory()->create();

        $this->json('DELETE', 'saas/languages/' . $language->uuid)
            ->assertOk();

        $this->assertSoftDeleted($language->getTable(), [
            'id' => $language->id,
        ]);

        Event::assertDispatched(
            LanguageDeleted::class,
            fn (LanguageDeleted $event) => $event->language->is($language)
        );
    }
}
