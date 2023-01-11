<?php

namespace SaasReady\Tests\Unit\Seeders;

use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\TestCase;

class GlobalDynamicSettingSeederTest extends TestCase
{
    public function testSeedOk()
    {
        $seeder = include __DIR__ . '/../../../src/Database/Migrations/2023_01_11_214900_seed_global_settings.php';
        $seeder->up();

        $this->assertDatabaseHas((new DynamicSetting())->getTable(), [
            'model_id' => null,
            'model_type' => null,
        ]);
    }
}
