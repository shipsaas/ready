<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Constants\CurrencyCode;
use SaasReady\Models\Currency;
use SaasReady\Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function testFindByUuid()
    {
        $currency = Currency::factory()->create();

        $foundCurrency = Currency::findByUuid($currency->uuid);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Currency::findByUuid($this->faker->uuid());
        $this->assertNull($nullCurrency);
    }

    public function testFindByCode()
    {
        $currency = Currency::factory()->create([
            'code' => CurrencyCode::ALGERIAN_DINAR,
        ]);

        $foundCurrency = Currency::findByCode($currency->code);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Currency::findByCode(CurrencyCode::AFGHAN_AFGHANI);
        $this->assertNull($nullCurrency);
    }
}
