<?php

namespace SaasReady\Http\Requests\Currency;

use SaasReady\Http\Requests\BaseFormRequest;

class CurrencyDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'currencies.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
