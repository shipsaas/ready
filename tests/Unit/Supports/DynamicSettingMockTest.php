<?php

namespace SaasReady\Tests\Unit\Supports;

use SaasReady\Models\Country;
use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\Supports\DynamicSettingMock;
use SaasReady\Tests\TestCase;

class DynamicSettingMockTest extends TestCase
{
    public function testMockShouldSetFakeSettings()
    {
        DynamicSettingMock::setSettings([
            'seth' => 'phat',
        ]);

        $this->assertSame('phat', setting('seth'));
    }

    public function testMockShouldSetFakeSettingsForSpecificInstance()
    {
        DynamicSettingMock::setSettings([
            'seth' => 'phat',
        ], $country = Country::factory()->create());

       $this->assertDatabaseHas((new DynamicSetting())->getTable(), [
            'model_id' => $country->id,
            'model_type' => $country->getMorphClass(),
           'settings->seth' => 'phat',
       ]);
    }
}
