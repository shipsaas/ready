<?php

namespace SaasReady\Tests\Feature\Controllers;

use SaasReady\Models\Currency;
use SaasReady\Tests\TestCase;

class CurrencyControllerTest extends TestCase
{
    public function testIndexEndpointReturnsAllCurrencies()
    {
        $currency = Currency::factory()->create();

        $this->json('GET', 'saas/currencies')
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $currency->uuid,
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
}
