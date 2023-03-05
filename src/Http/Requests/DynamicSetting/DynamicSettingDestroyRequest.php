<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'dynamic-settings.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
