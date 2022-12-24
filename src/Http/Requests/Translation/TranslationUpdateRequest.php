<?php

namespace SaasReady\Http\Requests\Translation;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Translation;

class TranslationUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => [
                'nullable',
                'string',
                Rule::unique((new Translation())->getTable(), 'code')
                    ->whereNot('key', $this->getTranslation()->key),
            ],
            'label' => 'required|string',
            'translations' => 'required|array',
        ];
    }

    public function getTranslation(): Translation
    {
        return $this->route('translation');
    }
}
