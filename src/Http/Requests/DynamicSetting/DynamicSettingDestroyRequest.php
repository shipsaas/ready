<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingDestroyRequest extends FormRequest
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
