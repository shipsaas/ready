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
        $migrationFiles = glob(__DIR__ . '/../src/Database/Migrations/*.php');

        foreach ($migrationFiles as $migrationFile) {
            $migrateInstance = include($migrationFile);
            $migrateInstance->up();
        }
    }
}
