<?php

namespace SaasReady\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SaasReady\SaasServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use DatabaseTransactions;

    protected function getPackageProviders($app): array
    {
        return [
            SaasServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $countryMigration = include($this->getMigrationFile('2022_12_05_232100_create_countries_table.php'));
        $countryMigration->up();
    }

    private function getMigrationFile(string $fileName): string
    {
        return __DIR__ . '/../src/Database/Migrations/' . $fileName;
    }
}
