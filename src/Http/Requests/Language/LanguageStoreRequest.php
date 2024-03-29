<?php

namespace SaasReady\Http\Requests\Language;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Language;

class LanguageStoreRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'languages.store';
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'min:2',
                'max:2',
                Rule::unique((new Language())->getTable(), 'code'),
            ],
            'name' => 'required|string',
            'is_active' => 'required|bool',
        ];
    }
}
