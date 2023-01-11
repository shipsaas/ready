<?php

namespace SaasReady\Tests\Feature\Controllers;

use SaasReady\Models\Country;
use SaasReady\Models\Currency;
use SaasReady\Models\DynamicSetting;
use SaasReady\Tests\Supports\DynamicSettingMock;
use SaasReady\Tests\TestCase;

class DynamicSettingsControllerTest extends TestCase
{
    public function testIndexEndpointReturnsPaginatedDynamicSettings()
    {
        $settings = DynamicSetting::factory()
            ->count(2)
            ->create();

        $this->json('GET', 'saas/dynamic-settings', [
            'limit' => 1,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $settings[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $settings[1]->uuid,
            ]);
    }

    public function testIndexEndpointFilterBySource()
    {
        $settings = DynamicSetting::factory()
            ->count(2)
            ->sequence(
                [
                    'model_id' => Country::factory()->create()->id,
                    'model_type' => Country::class,
                ],
                [
                    'model_id' => Currency::factory()->create()->id,
                    'model_type' => Currency::class,
                ],
            )
            ->create();

        $this->json('GET', 'saas/dynamic-settings', [
            'source_type' => Country::class,
            'limit' => 10,
            'page' => 1,
        ])
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $settings[0]->uuid,
            ])
            ->assertJsonMissing([
                'uuid' => $settings[1]->uuid,
            ]);
    }

    public function testIndexEndpointFilterBySourceNonExistsClassReturnsError()
    {
        $this->json('GET', 'saas/dynamic-settings', [
            'source_type' => 'App\\SethPhat',
            'limit' => 10,
            'page' => 1,
        ])->assertJsonValidationErrorFor('source_type');
    }

    public function testShowEndpointReturnsNotFound()
    {
        $this->json('GET', 'saas/dynamic-settings/' . $this->faker->uuid)
            ->assertNotFound();
    }

    public function testShowEndpointDynamicSettingByUuid()
    {
        $dynamicSetting = DynamicSettingMock::setSettings();

        $this->json('GET', 'saas/dynamic-settings/' . $dynamicSetting->uuid)
            ->assertOk()
            ->assertJsonFragment([
                'uuid' => $dynamicSetting->uuid,
            ]);
    }

    public function testStoreEndpointCreateNewRecord()
    {
        $currency = Currency::factory()->create();

        $this->json('POST', 'saas/dynamic-settings', [
            'source_id' => $currency->getKey(),
            'source_type' => $currency->getMorphClass(),
            'settings' => [
                'site_name' => 'Seth Phat',
            ],
        ])->assertCreated();

        $this->assertDatabaseHas((new DynamicSetting())->getTable(), [
            'model_id' => $currency->getKey(),
            'model_type' => $currency->getMorphClass(),
            'settings->site_name' => 'Seth Phat',
        ]);
    }

    public function testUpdateEndpointUpdatesTheRecord()
    {
        $currency = Currency::factory()->create();
        $dynamicSetting = DynamicSettingMock::setSettings([
            'seth' => 'tran',
        ], $currency);

        $this->json('PUT', 'saas/dynamic-settings/' . $dynamicSetting->uuid, [
            'settings' => [
                'seth' => 'phat',
            ],
        ])->assertOk();

        $dynamicSetting->refresh();

        $this->assertDatabaseHas($dynamicSetting->getTable(), [
            'model_id' => $currency->getKey(),
            'model_type' => $currency->getMorphClass(),
            'settings->seth' => 'phat',
        ]);

        $this->assertSame([
            'seth' => 'phat',
        ], $dynamicSetting->settings);
    }

    public function testUpdateEndpointUpdatesTheRecordAndChangeTheSource()
    {
        $currency = Currency::factory()->create();
        $dynamicSetting = DynamicSettingMock::setSettings([
            'seth' => 'tran',
        ], $currency);

        $newSource = Country::factory()->create();

        $this->json('PUT', 'saas/dynamic-settings/' . $dynamicSetting->uuid, [
            'source_id' => $newSource->id,
            'source_type' => $newSource->getMorphClass(),
            'settings' => [
                'seth' => 'phat',
            ],
        ])->assertOk();

        $dynamicSetting->refresh();

        $this->assertDatabaseHas($dynamicSetting->getTable(), [
            'model_id' => $newSource->getKey(),
            'model_type' => $newSource->getMorphClass(),
            'settings->seth' => 'phat',
        ]);

        $this->assertDatabaseMissing($dynamicSetting->getTable(), [
            'model_id' => $currency->getKey(),
            'model_type' => $currency->getMorphClass(),
            'settings->seth' => 'phat',
        ]);

        $this->assertSame([
            'seth' => 'phat',
        ], $dynamicSetting->settings);
    }

    public function testDestroyEndpointDeletesTheRecord()
    {
        $dynamicSetting = DynamicSettingMock::setSettings();

        $this->json('DELETE', 'saas/dynamic-settings/' . $dynamicSetting->uuid)
            ->assertOk();

        $this->assertDatabaseMissing($dynamicSetting->getTable(), [
            'id' => $dynamicSetting->id,
        ]);
    }
}
