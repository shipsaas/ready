<?php

namespace SaasReady\Http\Requests\DynamicSetting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class DynamicSettingIndexRequest extends FormRequest
{
    private ?Model $source = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'source_type' => 'nullable|string',
            'source_id' => 'nullable|int',
        ];
    }

    public function getRelatedModel(): ?Model
    {
        if (!$this->input('source_type') || !$this->input('source_id')) {
            return null;
        }

        return $this->source
            ??= $this->input('source_type')::find($this->input('source_id'));
    }
}
