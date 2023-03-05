<?php

namespace SaasReady\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Rules\ClassExistsRule;

class FileDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'files.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
