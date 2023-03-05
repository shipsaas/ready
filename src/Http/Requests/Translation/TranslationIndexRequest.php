<?php

namespace SaasReady\Http\Requests\Translation;

use SaasReady\Http\Requests\BaseFormRequest;

class TranslationIndexRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'search' => 'nullable|string',
        ];
    }

    public function getLimit(): int
    {
        return $this->input('limit') ?: 10;
    }

    public function getSearchKeyword(): ?string
    {
        return $this->input('search');
    }
}
