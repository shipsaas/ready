<?php

namespace SaasReady\Http\Requests\ReleaseNote;

use SaasReady\Http\Requests\BaseFormRequest;

class ReleaseNoteDestroyRequest extends BaseFormRequest
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
