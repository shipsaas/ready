<?php

namespace SaasReady\Http\Requests\Language;

use SaasReady\Http\Requests\BaseFormRequest;

class LanguageShowRequest extends BaseFormRequest
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
