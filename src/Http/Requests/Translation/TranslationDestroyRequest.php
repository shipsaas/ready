<?php

namespace SaasReady\Http\Requests\Translation;

use SaasReady\Http\Requests\BaseFormRequest;

class TranslationDestroyRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
