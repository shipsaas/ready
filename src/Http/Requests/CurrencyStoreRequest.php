<?php

namespace SaasReady\Http\Requests;

use Illuminate\Validation\Rule;
use SaasReady\Models\Currency;

class CurrencyStoreRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'min:3',
                'max:3',
                Rule::unique((new Currency())->getTable(), 'code'),
            ],
            'name' => 'required|string',
            'symbol' => 'required|string',
            'thousands_separator' => [
                'required',
                'string',
                Rule::in(',', '.'),
            ],
            'decimal_separator' => [
                'required',
                'string',
                Rule::in(',', '.'),
            ],
            'decimals' => 'required|int|min:0|max:6',
            'space_after_symbol' => 'required|bool',
        ];
    }
}
