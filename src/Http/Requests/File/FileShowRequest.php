<?php

namespace SaasReady\Http\Requests\File;

use SaasReady\Http\Requests\BaseFormRequest;

class FileShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'files.show';
    }

    public function rules(): array
    {
        return [
            'wants_preview' => 'nullable|boolean',
            'preview_type' => 'nullable|in:temporary,permanent',
            'expired_time' => [
                'required_if:preview_type,temporary',
                'date_format:Y-m-d H:i:s',
            ],
        ];
    }
}
