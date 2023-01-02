<?php

namespace SaasReady\Tests\Feature\Commands;

use SaasReady\Constants\CurrencyCode;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Currency;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;
use RuntimeException;
use TypeError;

class DeactivateEntityCommandTest extends TestCase
{
    public function testDeactivateNotSupportEntityThrowsAnError()
    {
        $this->expectException(RuntimeException::class);

        $this->artisan('saas-ready:deactivate-entity abcxyz code')
            ->execute();
    }

    public function testDeactivateNonExistsEntityThrowsAnError()
    {
        // CurrencyCode enum got our back
        $this->expectException(TypeError::class);

        $this->artisan('saas-ready:deactivate-entity currency AAAA')
            ->execute();
    }

    public function testDeactivateNonExistsEntityReturnsAnError()
    {
        $this->artisan('saas-ready:deactivate-entity currency USD')
            ->assertFailed()
            ->expectsOutputToContain('identifier does not exists')
            ->execute();
    }

    public function testDeactivateCurrencyOk()
    {
        $currency = Currency::factory()->create([
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'activated_at' => now(),
        ]);

        $this->artisan('saas-ready:deactivate-entity currency USD')
            ->assertOk()
            ->execute();

        $currency->refresh();

        $this->assertNull($currency->activated_at);
    }

    public function testDeactivateLanguageOk()
    {
        $language = Language::factory()->create([
            'code' => LanguageCode::ENGLISH,
            'activated_at' => now(),
        ]);

        $this->artisan('saas-ready:deactivate-entity language en')
            ->assertOk()
            ->execute();

        $language->refresh();

        $this->assertNull($language->activated_at);
    }
}
