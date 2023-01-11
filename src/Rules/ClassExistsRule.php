<?php

namespace SaasReady\Rules;

use Illuminate\Contracts\Validation\Rule;

class ClassExistsRule implements Rule
{
    private string $message;

    public function passes($attribute, $value): bool
    {
        if (!class_exists($value)) {
            $this->message = "The class of {$attribute} field does not exists.";

            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
