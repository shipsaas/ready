<?php

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
