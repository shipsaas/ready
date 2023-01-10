<?php

namespace SaasReady\Tests\Unit\Services\OctaneHooks;

use PHPUnit\Framework\TestCase;
use SaasReady\Models\Currency;
use SaasReady\Models\DynamicSetting;
use SaasReady\Services\OctaneHooks\ClearSaasReadyShortageCache;

class ClearSaasReadyShortageCacheTest extends TestCase
{
    public function testHandleFlushesTheShortageCache()
    {
        Currency::$currencyCaches = [
            new Currency(),
            new Currency(),
        ];
        DynamicSetting::$globalSettingShortage = new DynamicSetting();

        (new ClearSaasReadyShortageCache())->handle();

        $this->assertEmpty(Currency::$currencyCaches);
        $this->assertNull(DynamicSetting::$globalSettingShortage);
    }
}
