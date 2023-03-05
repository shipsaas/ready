<?php

namespace SaasReady\Http\Requests\Country;

use SaasReady\Http\Requests\BaseFormRequest;

class CountryDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'countries.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
