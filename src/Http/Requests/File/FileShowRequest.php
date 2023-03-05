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
        return [];
    }
}
