<?php

namespace SaasReady\Tests\Unit\Functions;

use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\TestCase;

class GetGlobalSettingsFunctionTest extends TestCase
{
    public function testSettingFuncReturnsTheSetting()
    {
        DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
            'settings' => [
                'site_name' => $siteName = 'Seth Phat',
            ],
        ]);

        $this->assertSame($siteName, setting('site_name'));
    }

    public function testSettingFuncReturnsTheFallbackValue()
    {
        DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
            'settings' => [
                'site_name' => 'Seth Phat',
            ],
        ]);

        $this->assertSame('hehehe', setting('site_name_nek', 'hehehe'));
    }
}
