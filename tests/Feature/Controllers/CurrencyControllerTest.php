<?php

namespace SaasReady\Tests\Feature\Controllers;

use Illuminate\Support\Facades\Event;
use SaasReady\Constants\CurrencyCode;
use SaasReady\Events\Currency\CurrencyCreated;
use SaasReady\Events\Currency\CurrencyDeleted;
use SaasReady\Events\Currency\CurrencyUpdated;
use SaasReady\Models\Currency;
use SaasReady\Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function testIndexEndpointReturnsAllCurrencies()
    {
        $currency = Currency::factory()->count(2)->create();

        $this->json('GET', 'saas/currencies')
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
        $currency = Currency::factory()->count(2)->sequence(
            [
                'code' => CurrencyCode::SINGAPORE_DOLLAR,
                'name' => 'Singapore',
            ],
            [
                'code' => CurrencyCode::ZIMBABWEAN_DOLLAR,
                'name' => 'Zimbabwe',
            ]
        )->create();

        $this->json('GET', 'saas/currencies', [
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

        $this->json('GET', 'saas/currencies', [
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

    public function testIndexEndpointReturnsActivatedCurrencies()
    {
        $currency = Currency::factory()->count(2)
            ->sequence(
                ['activated_at' => now()],
                ['activated_at' => null],
            )
            ->create();

        $this->json('GET', 'saas/currencies', ['is_active' => true])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $currency[1]->uuid,
            ]);
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/currencies/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointCurrencyByUuid()
    {
        $currency = Currency::factory()->create();

        $this->json('GET', 'saas/currencies/' . $currency->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        Event::fake([CurrencyCreated::class]);
        $this->travelTo('2022-10-10 10:00:00');

        $this->json('POST', 'saas/currencies/', [
            'code' => CurrencyCode::UNITED_STATES_DOLLAR->value,
            'name' => 'US Dollar',
            'symbol' => '$',
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'decimals' => '2',
            'space_after_symbol' => 1,
            'is_active' => true,
        ])->assertCreated();

        $this->assertDatabaseHas((new Currency())->getTable(), [
            'code' => CurrencyCode::UNITED_STATES_DOLLAR->value,
            'name' => 'US Dollar',
            'symbol' => '$',
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'decimals' => '2',
            'space_after_symbol' => 1,
            'activated_at' => '2022-10-10 10:00:00',
        ]);

        Event::assertDispatched(
            CurrencyCreated::class,
            fn (CurrencyCreated $event) => $event->currency->code === CurrencyCode::UNITED_STATES_DOLLAR
                && $event->currency->name === 'US Dollar'
        );
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        Event::fake([CurrencyUpdated::class]);

        $currency = Currency::factory()->create([
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'activated_at' => now(),
        ]);

        $this->json('PUT', 'saas/currencies/' . $currency->uuid, [
            'code' => CurrencyCode::VIETNAMESE_DONG->value,
            'name' => 'Vietnamese Dong',
            'is_active' => false,
        ])
            ->assertOk();

        $updatedCurrency = $currency->fresh();

        $this->assertSame($currency->id, $updatedCurrency->id);
        $this->assertNotSame($currency->code, $updatedCurrency->code);
        $this->assertNotSame($currency->name, $updatedCurrency->name);
        $this->assertNull($updatedCurrency->activated_at);

        $this->assertDatabaseMissing((new Currency())->getTable(), [
            'code' => CurrencyCode::UNITED_STATES_DOLLAR->value,
        ]);

        $this->assertDatabaseHas((new Currency())->getTable(), [
            'code' => CurrencyCode::VIETNAMESE_DONG->value,
            'name' => 'Vietnamese Dong',
        ]);

        Event::assertDispatched(
            CurrencyUpdated::class,
            fn (CurrencyUpdated $event) => $event->currency->code === CurrencyCode::VIETNAMESE_DONG
                && $event->currency->name === 'Vietnamese Dong'
        );
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        Event::fake([CurrencyDeleted::class]);

        $currency = Currency::factory()->create();

        $this->json('DELETE', 'saas/currencies/' . $currency->uuid)
            ->assertOk();

        $this->assertSoftDeleted($currency->getTable(), [
            'id' => $currency->id,
        ]);

        Event::assertDispatched(
            CurrencyDeleted::class,
            fn (CurrencyDeleted $event) => $event->currency->is($currency)
        );
    }
}
