<?php

namespace SaasReady\Http\Requests;

class CurrencyIndexRequest extends BaseFormRequest
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
