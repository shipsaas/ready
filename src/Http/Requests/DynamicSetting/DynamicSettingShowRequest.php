<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'dynamic-settings.show';
    }

    public function rules(): array
    {
        return [];
    }
}
