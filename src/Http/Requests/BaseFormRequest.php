<?php

namespace SaasReady\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    protected static ?Closure $customAuthorize = null;

    public function wantsPagination(): bool
    {
        return $this->input('type') !== 'all';
    }

    public static function setCustomAuthorize(callable $customAuthorize): void
    {
        static::$customAuthorize = $customAuthorize;
    }

    public function authorize(): bool
    {
        return call_user_func(static::$customAuthorize ?: fn () => true);
    }
}
