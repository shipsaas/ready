<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Database\Eloquent\Model;
use SaasReady\Http\Requests\BaseFormRequest;

class DynamicSettingUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_type' => 'nullable|string',
            'source_id' => 'nullable|int',
            'settings' => 'required|array',
        ];
    }

    public function getRelatedModel(): ?Model
    {
        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
