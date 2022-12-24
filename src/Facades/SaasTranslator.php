<?php

namespace SaasReady\Facades;

use Illuminate\Support\Facades\Facade;
use SaasReady\Services\Translator;

/**
 * @method static string translate(string $key, array $variables = [])
 */
class SaasTranslator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Translator::class;
    }
}
