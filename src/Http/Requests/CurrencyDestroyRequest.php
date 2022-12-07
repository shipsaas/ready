<?php

namespace SaasReady\Http\Requests;

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
