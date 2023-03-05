<?php

namespace SaasReady\Http\Requests\Event;

use SaasReady\Http\Requests\BaseFormRequest;

class EventShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'events.show';
    }

    public function rules(): array
    {
        return [
            'load_related_model' => 'nullable|bool',
        ];
    }
}
