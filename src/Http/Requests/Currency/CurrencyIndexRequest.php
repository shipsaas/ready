<?php

namespace SaasReady\Http\Requests\Currency;

use SaasReady\Http\Requests\BaseFormRequest;

class CurrencyIndexRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => 'nullable|int|max:100',
        ];
    }

    public function getLimit(): int
    {
        return $this->input('limit') ?: 10;
    }

    public function wantsActivated(): bool
    {
        return $this->boolean('is_active');
    }
}
