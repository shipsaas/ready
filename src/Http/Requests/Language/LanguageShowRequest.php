<?php

namespace SaasReady\Http\Requests\Language;

use SaasReady\Http\Requests\BaseFormRequest;

class LanguageShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'languages.show';
    }

    public function rules(): array
    {
        return [];
    }
}
