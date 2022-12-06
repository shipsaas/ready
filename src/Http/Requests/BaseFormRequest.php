<?php

namespace SaasReady\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    public function wantsPagination(): bool
    {
        return $this->input('type') !== 'all';
    }
}
