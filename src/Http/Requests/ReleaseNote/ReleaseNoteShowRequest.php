<?php

namespace SaasReady\Http\Requests\ReleaseNote;

use SaasReady\Http\Requests\BaseFormRequest;

class ReleaseNoteShowRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'release-notes.show';
    }

    public function rules(): array
    {
        return [];
    }
}
