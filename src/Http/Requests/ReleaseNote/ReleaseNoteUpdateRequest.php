<?php

namespace SaasReady\Http\Requests\ReleaseNote;

use Illuminate\Validation\Rule;
use SaasReady\Http\Requests\BaseFormRequest;
use SaasReady\Models\Country;

class ReleaseNoteUpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'version' => 'required|string',
            'note' => 'required|string',
        ];
    }
}
