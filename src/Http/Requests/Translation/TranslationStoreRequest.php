<?php

namespace SaasReady\Http\Requests\Translation;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Translation;

class TranslationStoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => [
                'required',
                'string',
                'min:2',
                'max:2',
                Rule::unique((new Translation())->getTable(), 'key'),
            ],
            'label' => 'required|string',
            'translations' => 'required|array',
        ];
    }
}
