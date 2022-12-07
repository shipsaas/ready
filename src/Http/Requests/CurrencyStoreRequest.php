<?php

namespace SaasReady\Http\Requests;

class CurrencyStoreRequest extends BaseFormRequest
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
