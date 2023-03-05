<?php

namespace SaasReady\Http\Requests\Language;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Language;

class LanguageUpdateRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'languages.update';
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
            'is_active' => 'required|bool',
        ];
    }

    public function getLanguage(): Language
    {
        return $this->route('language');
    }
}
