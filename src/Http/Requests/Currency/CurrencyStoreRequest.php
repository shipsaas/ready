<?php

namespace SaasReady\Http\Requests\Currency;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Currency;

class CurrencyStoreRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'currencies.store';
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
            'is_active' => 'nullable|bool',
        ];
    }
}
