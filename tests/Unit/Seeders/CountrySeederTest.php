<?php

namespace SaasReady\Tests\Unit\Seeders;

use SaasReady\Constants\CountryCode;
use SaasReady\Models\Country;
use SaasReady\Tests\TestCase;

class CountrySeederTest extends TestCase
{
    public function testSeederSeedsAllCountries()
    {
        $this->travelTo('2022-10-23 10:00:00');

        $seeder = include __DIR__ . '/../../../src/Database/Migrations/2022_12_10_213900_seed_countries.php';
        $seeder->up();

        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => CountryCode::VIETNAM,
            'name' => 'Viet Nam',
        ]);
        $this->assertDatabaseHas((new Country())->getTable(), [
            'code' => CountryCode::UNITED_STATES,
            'name' => 'United States',
        ]);
    }
}
