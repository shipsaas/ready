<?php

use SaasReady\Models\DynamicSetting;
use SaasReady\Services\Translator;

if (!function_exists('saasTrans')) {
    /**
     * Helper function to quickly translate a key
     *
     * @param string $key
     * @param array $variables
     *
     * @return string
     */
    function saasTrans(string $key, array $variables = []): string
    {
        return app(Translator::class)->translate($key, $variables);
    }
}

if (!function_exists('settings')) {
    /**
     * Helper function to quickly get the setting (global)
     */
    function setting(string $key, mixed $fallback = null): mixed
    {
        return DynamicSetting::getGlobal()?->getSetting($key, $fallback) ?? $fallback;
    }
}
