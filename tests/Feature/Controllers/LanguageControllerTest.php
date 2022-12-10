<?php

namespace SaasReady\Tests\Feature\Controllers;

use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function testIndexEndpointReturnsAllCurrencies()
    {
        $currency = Language::factory()->count(2)->create();

        $this->json('GET', 'saas/countries')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency[0]->uuid,
            ])
            ->assertJsonFragment([
                'uuid' => $currency[1]->uuid,
            ]);
    }

    public function testIndexEndpointReturnsPaginatedCurrencies()
    {
        $currency = Language::factory()->count(2)->sequence(
            [
                'code' => LanguageCode::VIETNAMESE,
                'name' => 'Singapore',
            ],
            [
                'code' => LanguageCode::ENGLISH,
                'name' => 'Vietnam',
            ]
        )->create();

        $this->json('GET', 'saas/countries', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $currency[1]->uuid,
            ]);

        $this->json('GET', 'saas/countries', [
            'type' => 'paginated',
            'limit' => 1,
            'page' => 2,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency[1]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $currency[0]->uuid,
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/countries/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointCurrencyByUuid()
    {
        $currency = Language::factory()->create();

        $this->json('GET', 'saas/countries/' . $currency->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        $this->json('POST', 'saas/countries/', [
            'code' => LanguageCode::UNITED_STATES->value,
            'name' => 'United States',
            'dial_code' => '+1',
            'continent' => 'North America',
        ])->assertCreated();

        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => LanguageCode::UNITED_STATES->value,
            'name' => 'United States',
            'dial_code' => '+1',
            'continent' => 'North America',
        ]);
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        $currency = Language::factory()->create([
            'code' => LanguageCode::UNITED_STATES,
        ]);

        $this->json('PUT', 'saas/countries/' . $currency->uuid, [
            'code' => LanguageCode::VIETNAM->value,
            'name' => 'Vietnam',
            'dial_code' => '+84',
            'continent' => 'SEA',
        ])
            ->assertOk();

        $updatedCurrency = $currency->fresh();

        $this->assertSame($currency->id, $updatedCurrency->id);
        $this->assertNotSame($currency->code, $updatedCurrency->code);
        $this->assertNotSame($currency->name, $updatedCurrency->name);

        $this->assertDatabaseMissing((new Country())->getTable(), [
            'code' => LanguageCode::UNITED_STATES->value,
        ]);

        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => LanguageCode::VIETNAM->value,
            'name' => 'Vietnam',
            'dial_code' => '+84',
            'continent' => 'SEA',
        ]);
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        $currency = Language::factory()->create();

        $this->json('DELETE', 'saas/countries/' . $currency->uuid)
            ->assertOk();

        $this->assertSoftDeleted($currency->getTable(), [
            'id' => $currency->id,
        ]);
    }
}
