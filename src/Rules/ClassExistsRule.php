<?php

namespace SaasReady\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ClassExistsRule implements Rule
{
    private string $message;

    public function __construct(private readonly bool $requiresEloquent = false)
    {
    }

    public function passes($attribute, $value): bool
    {
        if (!class_exists($value)) {
            $this->message = "The class of {$attribute} field does not exists.";

            return false;
        }

        if ($this->requiresEloquent) {
            $model = app($value);
            if (!($model instanceof Model)) {
                $this->message = "The class of {$attribute} field is not an Eloquent Class";

                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
