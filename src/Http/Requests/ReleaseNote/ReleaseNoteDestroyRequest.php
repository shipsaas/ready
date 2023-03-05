<?php

namespace SaasReady\Http\Requests\ReleaseNote;

use SaasReady\Http\Requests\BaseFormRequest;

class ReleaseNoteDestroyRequest extends BaseFormRequest
{
    protected function getEndpointName(): string
    {
        return 'release-notes.destroy';
    }

    public function rules(): array
    {
        return [];
    }
}
