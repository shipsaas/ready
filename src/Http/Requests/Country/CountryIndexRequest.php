<?php

namespace SaasReady\Http\Requests\Country;

use SaasReady\Http\Requests\BaseFormRequest;

class CountryIndexRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'countries.index';
    }

    public function rules(): array
    {
        return [
            'limit' => 'nullable|int|max:100',
        ];
    }

    public function getLimit(): int
    {
        return $this->input('limit') ?: 10;
    }
}
