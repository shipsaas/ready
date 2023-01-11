<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Database\Eloquent\Model;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingStoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_type' => [
                'required',
                'string',
                new ClassExistsRule(),
            ],
            'source_id' => 'required|int',
            'settings' => 'required|array',
        ];
    }

    public function getRelatedModel(): ?Model
    {
        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
