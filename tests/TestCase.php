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

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            SaasServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // prefer this way, because we will have some migrations that seed the data for tables
        $migrationFiles = [
            __DIR__ . '/../src/Database/Migrations/2022_12_05_232100_create_countries_table.php',
            __DIR__ . '/../src/Database/Migrations/2022_12_06_151600_create_currencies_table.php',
            __DIR__ . '/../src/Database/Migrations/2022_12_10_111611_create_languages_table.php',
            __DIR__ . '/../src/Database/Migrations/2022_12_16_225300_create_events_table.php',
        ];

        foreach ($migrationFiles as $migrationFile) {
            $migrateInstance = include $migrationFile;
            $migrateInstance->up();
        }
    }
}
