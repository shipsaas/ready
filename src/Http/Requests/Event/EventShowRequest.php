<?php

namespace SaasReady\Http\Requests\Event;

use SaasReady\Http\Requests\BaseFormRequest;

class EventShowRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'load_related_model' => 'nullable|bool',
        ];
    }
}
