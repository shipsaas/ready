<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Constants\CountryCode;
use SaasReady\Models\Country;
use SaasReady\Tests\TestCase;

class CountryTest extends TestCase
{
    public function testFindByUuid()
    {
        $currency = Country::factory()->create();

        $foundCurrency = Country::findByUuid($currency->uuid);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Country::findByUuid($this->faker->uuid());
        $this->assertNull($nullCurrency);
    }

    public function testFindByCode()
    {
        $currency = Country::factory()->create([
            'code' => CountryCode::VIETNAM,
        ]);

        $foundCurrency = Country::findByCode($currency->code);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Country::findByCode(CountryCode::UNITED_STATES);
        $this->assertNull($nullCurrency);
    }
}
