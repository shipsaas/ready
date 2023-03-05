<?php

namespace SaasReady\Http\Requests\ReleaseNote;

use SaasReady\Http\Requests\BaseFormRequest;

class ReleaseNoteIndexRequest extends BaseFormRequest
{
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
}
