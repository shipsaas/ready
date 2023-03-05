<?php

namespace SaasReady\Http\Requests\Translation;

use SaasReady\Http\Requests\BaseFormRequest;

class TranslationDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'translations.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
