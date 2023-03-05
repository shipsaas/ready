<?php

namespace SaasReady\Http\Requests\Country;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Country;

class CountryUpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
                'string',
                'min:2',
                'max:2',
                Rule::unique((new Country())->getTable(), 'code')
                    ->whereNot('code', $this->getCountry()->code->value),
            ],
            'name' => 'nullable|string',
            'continent' => 'nullable|string',
            'dial_code' => 'nullable|string|starts_with:+',
        ];
    }

    public function getCountry(): Country
    {
        return $this->route('country');
    }
}
