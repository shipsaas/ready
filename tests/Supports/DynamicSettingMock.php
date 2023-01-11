<?php

namespace SaasReady\Tests\Supports;

use Illuminate\Database\Eloquent\Model;
use SaasReady\Models\DynamicSetting;

class DynamicSettingMock
{
    public static function setSettings(array $settings = [], ?Model $model = null): void
    {
        DynamicSetting::updateOrCreate([
            'model_id' => $model?->getKey() ?? null,
            'model_type' => $model?->getMorphClass() ?? null,
        ], [
            'settings' => $settings,
        ]);
    }
}
