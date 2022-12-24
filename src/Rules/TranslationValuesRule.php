<?php

namespace SaasReady\Rules;

use Illuminate\Contracts\Validation\Rule;
use SaasReady\Constants\LanguageCode;

class TranslationValuesRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        return collect($value)
            ->filter(fn ($value, $key) => !LanguageCode::tryFrom($key))
            ->isEmpty();
    }

    public function message(): string
    {
        return 'Translation values had invalid language code';
    }
}
