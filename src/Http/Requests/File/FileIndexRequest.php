<?php

namespace SaasReady\Http\Requests\File;

use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class FileIndexRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'files.index';
    }

    public function rules(): array
    {
        return [
            'limit' => 'required|int|max:100',
            'page' => 'required|int|min:1',
            'source_type' => [
                'nullable',
                'string',
                new ClassExistsRule(),
            ],
        ];
    }
}
