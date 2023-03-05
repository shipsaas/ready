<?php

namespace SaasReady\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SaasReady\Auth\ReadyAuthorization;

abstract class BaseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return call_user_func(
            ReadyAuthorization::getAuthorization($this->getEndpointName()),
            $this
        );
    }

    abstract protected function getEndpointName(): string;

    public function wantsPagination(): bool
    {
        return $this->input('type') !== 'all';
    }
}
