<?php

namespace SaasReady\Http\Requests\Currency;

use SaasReady\Http\Requests\BaseFormRequest;

class CurrencyShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'currencies.show';
    }

    public function rules(): array
    {
        return [];
    }
}
