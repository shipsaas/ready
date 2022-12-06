<?php

namespace SaasReady\Http\Requests;

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
