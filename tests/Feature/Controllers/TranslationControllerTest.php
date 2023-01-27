<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Support\Facades\Event;
use SaasReady\Events\Translation\TranslationCreated;
use SaasReady\Events\Translation\TranslationDeleted;
use SaasReady\Events\Translation\TranslationUpdated;
use SaasReady\Models\Translation;
use SaasReady\Tests\TestCase;

class TranslationControllerTest extends TestCase
{
    public function testIndexEndpointReturnsPaginatedTranslations()
    {
        $translations = Translation::factory()
            ->count(2)
            ->create();

        $this->json('GET', 'saas/translations', [
            'limit' => 1,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $translations[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $translations[1]->uuid,
            ]);
    }

    public function testIndexEndpointFilterByKeyword()
    {
        $translations = Translation::factory()
            ->count(3)
            ->sequence(
                ['label' => 'Seth Tran'],
                ['label' => 'Seth Phat'],
                ['translations' => ['en' => 'Seth Tran nek']],
            )
            ->create();

        $this->json('GET', 'saas/translations', [
            'limit' => 10,
            'page' => 1,
            'search' => 'Seth Tran',
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $translations[0]->uuid,
            ])
            ->assertJsonFragment([
                'uuid' => $translations[2]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $translations[1]->uuid,
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/translations/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointTranslationByUuid()
    {
        $translation = Translation::factory()->create();

        $this->json('GET', 'saas/translations/' . $translation->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $translation->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        Event::fake([
            TranslationCreated::class,
        ]);

        $this->json('POST', 'saas/translations', [
            'key' => 'seth.phat',
            'label' => 'Seth Phat',
            'translations' => [
                'vi' => 'Day la Seth Phat',
            ],
        ])->assertCreated();

        $this->assertDatabaseHas((new Translation())->getTable(), [
            'key' => 'seth.phat',
            'label' => 'Seth Phat',
            'translations->vi' => 'Day la Seth Phat',
        ]);

        Event::assertDispatched(
            TranslationCreated::class,
            fn (TranslationCreated $event) => $event->translation->key === 'seth.phat'
                && $event->translation->label === 'Seth Phat'
                && $event->translation->translations['vi'] === 'Day la Seth Phat'
        );
    }

    public function testStoreEndpointCreateFailedDueToInvalidTranslationFormat()
    {
        $this->json('POST', 'saas/translations', [
            'key' => 'seth.phat',
            'label' => 'Seth Phat',
            'translations' => 'wrong-type-for-this',
        ])->assertJsonValidationErrorFor('translations');

        $this->json('POST', 'saas/translations', [
            'key' => 'seth.phat',
            'label' => 'Seth Phat',
            'translations' => [
                'fake-language-code' => 'Day la Seth Phat',
            ],
        ])->assertJsonValidationErrorFor('translations');
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        Event::fake([
            TranslationUpdated::class,
        ]);

        $translation = Translation::factory()->create([
            'key' => 'seth.phat',
        ]);

        $this->json('PUT', 'saas/translations/' . $translation->uuid, [
            'key' => 'seth.phat.nek',
            'label' => 'Seth Phat Nek',
            'translations' => [
                'en' => 'This is Seth Phat',
            ],
        ])->assertOk();

        $updatedTranslation = $translation->fresh();

        $this->assertSame($translation->id, $updatedTranslation->id);
        $this->assertNotSame($translation->key, $updatedTranslation->key);
        $this->assertNotSame($translation->label, $updatedTranslation->label);

        $this->assertDatabaseMissing((new Translation())->getTable(), [
            'key' => 'seth.phat',
        ]);

        $this->assertDatabaseHas((new Translation())->getTable(), [
            'key' => 'seth.phat.nek',
            'label' => 'Seth Phat Nek',
            'translations->en' => 'This is Seth Phat',
        ]);

        Event::assertDispatched(
            TranslationUpdated::class,
            fn (TranslationUpdated $event) => $event->translation->is($translation)
                && $event->translation->is($updatedTranslation)
        );
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        Event::fake([
            TranslationDeleted::class,
        ]);

        $translation = Translation::factory()->create();

        $this->json('DELETE', 'saas/translations/' . $translation->uuid)
            ->assertOk();

        $this->assertSoftDeleted($translation->getTable(), [
            'id' => $translation->id,
        ]);

        Event::assertDispatched(
            TranslationDeleted::class,
            fn (TranslationDeleted $event) => $event->translation->is($translation)
        );
    }
}
