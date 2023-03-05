<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingIndexRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'dynamic-settings.index';
    }

    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'source_type' => [
                'nullable',
                'string',
                new ClassExistsRule(),
            ],
        ];
    }
}
