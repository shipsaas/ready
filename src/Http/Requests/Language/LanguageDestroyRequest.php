<?php

namespace SaasReady\Http\Requests\Language;

use SaasReady\Http\Requests\BaseFormRequest;

class LanguageDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'languages.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
