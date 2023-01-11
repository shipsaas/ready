<?php

namespace SaasReady\Tests\Unit\Traits;

use SaasReady\Models\Country;
use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\TestCase;
use SaasReady\Traits\HasDynamicSettings;

class HasDynamicSettingsTest extends TestCase
{
    private $instance;

    protected function setUp(): void
    {
        parent::setUp();

        $country = Country::factory()->create();
        $this->instance = new class () extends Country {
            use HasDynamicSettings;
        };

        $this->instance->id = $country->id;
    }

    public function testInstanceBelongsToADynamicSetting()
    {
        $dynamicSetting = DynamicSetting::factory()->create([
            'model_id' => $this->instance->id,
            'model_type' => $this->instance->getMorphClass(),
        ]);

        $this->assertTrue($dynamicSetting->is($this->instance->dynamicSetting));
    }

    public function testGetSettingSingleLevelReturnsTheSettingValue()
    {
        DynamicSetting::factory()->create([
            'model_id' => $this->instance->id,
            'model_type' => $this->instance->getMorphClass(),
            'settings' => [
                'site_name' => $siteName = 'Seth Phat',
                'site' => [
                    'url' => $siteUrl = 'https://sethphat.dev',
                ],
            ],
        ]);

        $this->assertSame($siteName, $this->instance->getSetting('site_name'));
        $this->assertSame($siteUrl, $this->instance->getSetting('site.url'));
    }

    public function testGetSettingSingleLevelFallbacksToTheFallbackValue()
    {
        $this->assertSame('no', $this->instance->getSetting('site_name_nek', 'no'));
    }

    public function testGetSettingMultiLevelReturnsTheFallbackOfTheFirstLayer()
    {
        DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
            'settings' => [
                'site_name' => $siteName = 'Seth Phat',
                'site' => [
                    'url' => $siteUrl = 'https://sethphat.dev',
                ],
            ],
        ]);

        DynamicSetting::factory()->create([
            'model_id' => $this->instance->id,
            'model_type' => $this->instance->getMorphClass(),
            'settings' => [],
        ]);

        $this->assertSame($siteName, $this->instance->getMultiLevelsSetting('site_name'));
        $this->assertSame($siteUrl, $this->instance->getMultiLevelsSetting('site.url'));
    }

    public function testGetSettingMultiLevelReturnsTheFallbackValueSinceNoRecord()
    {
        DynamicSetting::factory()->create([
            'model_id' => null,
            'model_type' => null,
            'settings' => [
                'site_name' => $siteName = 'Seth Phat',
                'site' => [
                    'url' => $siteUrl = 'https://sethphat.dev',
                ],
            ],
        ]);

        DynamicSetting::factory()->create([
            'model_id' => $this->instance->id,
            'model_type' => $this->instance->getMorphClass(),
            'settings' => [],
        ]);

        $this->assertSame(null, $this->instance->getMultiLevelsSetting('seth_phat'));
    }
}
