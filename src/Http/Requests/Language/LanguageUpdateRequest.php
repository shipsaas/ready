<?php

namespace SaasReady\Http\Requests\Language;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Language;

class LanguageUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
                'string',
                'min:2',
                'max:2',
                Rule::unique((new Language())->getTable(), 'code')
                    ->whereNot('code', $this->getLanguage()->code->value),
            ],
            'name' => 'nullable|string',
        ];
    }

    public function getLanguage(): Language
    {
        return $this->route('language');
    }
}
