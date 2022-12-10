<?php

namespace SaasReady\Http\Requests\Country;

use SaasReady\Http\Requests\BaseFormRequest;

class CountryDestroyRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
