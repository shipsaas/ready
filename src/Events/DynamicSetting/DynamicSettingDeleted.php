<?php

namespace SaasReady\Events\DynamicSetting;

use Illuminate\Queue\SerializesModels;
use SaasReady\Models\DynamicSetting;

class DynamicSettingDeleted
{
    use SerializesModels;

    public function __construct(public DynamicSetting $dynamicSetting)
    {
    }
}
