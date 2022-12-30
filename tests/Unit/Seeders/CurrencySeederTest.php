<?php

namespace SaasReady\Tests\Unit\Seeders;

use SaasReady\Constants\CurrencyCode;
use SaasReady\Models\Currency;
use SaasReady\Tests\TestCase;

class CurrencySeederTest extends TestCase
{
    public function testSeederSeedsAllCountries()
    {
        $this->travelTo('2022-10-23 10:00:00');

        $seeder = include __DIR__ . '/../../../src/Database/Migrations/2022_12_30_182100_seed_currencies.php';
        $seeder->up();

        $this->assertDatabaseHas((new Currency())->getTable(), [
            'code' => CurrencyCode::UNITED_STATES_DOLLAR,
        ]);
        $this->assertDatabaseHas((new Currency())->getTable(), [
            'code' => CurrencyCode::VIETNAMESE_DONG,
        ]);

        // to ensure every enum would be computed normally fine
        Currency::all()
            ->each(fn (Currency $currency) => $this->assertInstanceOf(CurrencyCode::class, $currency->code));
    }
}
