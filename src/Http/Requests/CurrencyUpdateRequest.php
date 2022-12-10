<?php

namespace SaasReady\Http\Requests;

use Illuminate\Validation\Rule;
use SaasReady\Models\Currency;

class CurrencyUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'nullable',
                'string',
                'min:3',
                'max:3',
                Rule::unique((new Currency())->getTable(), 'code')
                    ->whereNot('code', $this->route('currency')),
            ],
            'name' => 'nullable|string',
            'symbol' => 'nullable|string',
            'thousands_separator' => [
                'nullable',
                'string',
                Rule::in(',', '.'),
            ],
            'decimal_separator' => [
                'nullable',
                'string',
                Rule::in(',', '.'),
            ],
            'decimals' => 'nullable|int|min:0|max:6',
            'space_after_symbol' => 'nullable|bool',
        ];
    }
}
