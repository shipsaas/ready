<?php

namespace SaasReady\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SaasReady\Models\Country;
use SaasReady\Models\DynamicSetting;

class DynamicSettingFactory extends Factory
{
    protected $model = DynamicSetting::class;

    public function definition(): array
    {
        return [
            'model_id' => fn () => Country::factory()->create(),
            'model_type' => Country::class,
            'settings' => [
                'site_name' => 'Seth Phat',
                'is_enabled' => true,
            ],
        ];
    }
}
