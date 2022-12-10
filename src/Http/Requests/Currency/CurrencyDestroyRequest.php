<?php

namespace SaasReady\Http\Requests\Currency;

use SaasReady\Http\Requests\BaseFormRequest;

class CurrencyDestroyRequest extends BaseFormRequest
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
