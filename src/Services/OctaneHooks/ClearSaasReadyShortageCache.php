<?php

namespace SaasReady\Services\OctaneHooks;

use SaasReady\Models\Currency;
use SaasReady\Models\DynamicSetting;

/**
 * @note: for Octane users only
 *
 * Inject this class to your `config/octane.php`, in RequestTerminated::class or something
 * In order to clear the shortage cache per request.
 */
class ClearSaasReadyShortageCache
{
    public function handle(): void
    {
        Currency::$currencyCaches = [];
        DynamicSetting::$globalSettingShortage = null;
    }
}
