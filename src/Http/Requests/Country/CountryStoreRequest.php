<?php

namespace SaasReady\Http\Requests\Country;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Country;

class CountryStoreRequest extends BaseFormRequest
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
                Rule::unique((new Country())->getTable(), 'code'),
            ],
            'name' => 'required|string',
            'continent' => 'required|string',
            'dial_code' => 'required|string|starts_with:+',
        ];
    }
}
