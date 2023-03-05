<?php

namespace SaasReady\Http\Requests\Country;

use SaasReady\Http\Requests\BaseFormRequest;

class CountryShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'countries.show';
    }

    public function rules(): array
    {
        return [];
    }
}
