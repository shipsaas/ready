<?php

namespace SaasReady\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use SaasReady\Models\DynamicSetting;

/**
 * @mixin Model
 *
 * @property-read DynamicSetting|null $dynamicSetting
 */
trait HasDynamicSettings
{
    public function dynamicSetting(): MorphOne
    {
        return $this->morphOne(DynamicSetting::class, 'model');
    }

    /**
     * Get the setting from single level
     */
    public function getSetting(string $key, mixed $fallback = null): mixed
    {
        return $this->dynamicSetting?->getSetting($key, $fallback) ?? $fallback;
    }

    /**
     * Get the setting from 2 levels:
     * - First level: current instance
     * - Fallback level: global instance
     */
    public function getSettingWithGlobalFallback(string $key, mixed $fallback = null): mixed
    {
        return $this->dynamicSetting?->getSetting($key, $fallback)
            ?? DynamicSetting::getGlobal()?->getSetting($key, $fallback)
            ?? $fallback;
    }
}
