<?php

namespace SaasReady\Tests\Unit\Models;

use SaasReady\Models\Currency;
use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\TestCase;

class DynamicSettingTest extends TestCase
{
    public function testGetGlobalInstance()
    {
        $dynamicGlobalInstance = DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
        ]);

        $globalInstance = DynamicSetting::getGlobal();

        $this->assertTrue($globalInstance->is($dynamicGlobalInstance));
        $this->assertTrue($globalInstance->is(DynamicSetting::$globalSettingShortage));
    }

    public function testDynamicSettingBelongsToAnInstance()
    {
        $currency = Currency::factory()->create();
        $dynamicGlobalInstance = DynamicSetting::factory()->create([
            'model_id' => $currency->id,
            'model_type' => $currency->getMorphClass(),
        ]);

        $this->assertTrue(
            $dynamicGlobalInstance->model()->first()->is($currency)
        );
    }

    public function testGetGlobalInstanceWithoutGlobalCache()
    {
        config([
            'saas-ready.dynamic-settings.use-shortage-cache-global' => false,
        ]);

        $dynamicGlobalInstance = DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
        ]);

        $globalInstance = DynamicSetting::getGlobal();

        $this->assertTrue($globalInstance->is($dynamicGlobalInstance));
        $this->assertNull(DynamicSetting::$globalSettingShortage);
    }
}
