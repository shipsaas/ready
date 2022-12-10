<?php

namespace SaasReady\Http\Requests\Language;

use SaasReady\Http\Requests\BaseFormRequest;

class LanguageIndexRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'limit' => 'nullable|int|max:100',
            'is_active' => 'nullable|bool',
        ];
    }

    public function getLimit(): int
    {
        return $this->input('limit') ?: 10;
    }

    public function wantsActiveLanguages(): bool
    {
        return $this->boolean('is_active');
    }
}
