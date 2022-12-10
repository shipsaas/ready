<?php

namespace SaasReady\Http\Requests\Currency;

use SaasReady\Http\Requests\BaseFormRequest;

class CurrencyShowRequest extends BaseFormRequest
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
