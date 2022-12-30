<?php

namespace SaasReady\Http\Requests\Language;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Language;

class LanguageStoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
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
