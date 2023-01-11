<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Database\Eloquent\Model;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class DynamicSettingUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_type' => [
                'nullable',
                'string',
                new ClassExistsRule(),
            ],
            'source_id' => 'nullable|int',
            'settings' => 'required|array',
        ];
    }

    public function getRelatedModel(): ?Model
    {
        if (!$this->filled('source_type') || !$this->filled('source_id')) {
            return null;
        }

        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
