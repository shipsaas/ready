<?php

namespace SaasReady\Tests\Feature\Commands;

use SaasReady\Constants\CurrencyCode;
use SaasReady\Constants\LanguageCode;
use SaasReady\Models\Currency;
use SaasReady\Models\Language;
use SaasReady\Tests\TestCase;
use RuntimeException;
use TypeError;

class ActivateEntityCommandTest extends TestCase
{
    public function testActivateNotSupportEntityThrowsAnError()
    {
        $this->expectException(RuntimeException::class);

        $this->artisan('saas-ready:activate-entity abcxyz code')
            ->execute();
    }

    public function testActivateNonExistsEntityThrowsAnError()
    {
        // CurrencyCode enum got our back
        $this->expectException(TypeError::class);

        $this->artisan('saas-ready:activate-entity currency AAAA')
            ->execute();
    }

    public function testActivateNonExistsEntityReturnsAnError()
    {
        $this->artisan('saas-ready:activate-entity currency USD')
            ->assertFailed()
            ->expectsOutputToContain('identifier does not exists')
            ->execute();
    }

    public function testActivateCurrencyOk()
    {
        $currency = Currency::factory()->create([
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
            'activated_at' => null,
        ]);

        $this->artisan('saas-ready:activate-entity currency USD')
            ->assertOk()
            ->execute();

        $currency->refresh();

        $this->assertNotNull($currency->activated_at);
    }

    public function testActivateLanguageOk()
    {
        $language = Language::factory()->create([
            'code' => LanguageCode::ENGLISH,
            'activated_at' => null,
        ]);

        $this->artisan('saas-ready:activate-entity language en')
            ->assertOk()
            ->execute();

        $language->refresh();

        $this->assertNotNull($language->activated_at);
    }
}
