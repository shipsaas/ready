<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;

class LanguageTest extends TestCase
{
    public function testFindByUuid()
    {
        $currency = Language::factory()->create();

        $foundCurrency = Language::findByUuid($currency->uuid);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Language::findByUuid($this->faker->uuid());
        $this->assertNull($nullCurrency);
    }

    public function testFindByCode()
    {
        $currency = Language::factory()->create([
            'code' => LanguageCode::ENGLISH,
        ]);

        $foundCurrency = Language::findByCode($currency->code);

        $this->assertNotNull($foundCurrency);
        $this->assertTrue($foundCurrency->is($currency));

        $nullCurrency = Language::findByCode(LanguageCode::VIETNAMESE);
        $this->assertNull($nullCurrency);
    }
}
