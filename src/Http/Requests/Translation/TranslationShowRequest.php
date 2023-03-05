<?php

namespace SaasReady\Http\Requests\Translation;

use SaasReady\Http\Requests\BaseFormRequest;

class TranslationShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'translations.show';
    }

    public function rules(): array
    {
        return [];
    }
}
