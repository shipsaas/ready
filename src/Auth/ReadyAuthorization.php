<?php

namespace SaasReady\Auth;

use Closure;

final class ReadyAuthorization
{
    /**
     * @var array<string, Closure>
     */
    private static array $customAuthorizations = [
        'events.index' => null,
        'events.show' => null,

        'countries.index' => null,
        'countries.show' => null,
        'countries.store' => null,
        'countries.update' => null,
        'countries.destroy' => null,

        'currencies.index' => null,
        'currencies.show' => null,
        'currencies.store' => null,
        'currencies.update' => null,
        'currencies.destroy' => null,

        'languages.index' => null,
        'languages.show' => null,
        'languages.store' => null,
        'languages.update' => null,
        'languages.destroy' => null,

        'release-notes.index' => null,
        'release-notes.show' => null,
        'release-notes.store' => null,
        'release-notes.update' => null,
        'release-notes.destroy' => null,

        'dynamic-settings.index' => null,
        'dynamic-settings.show' => null,
        'dynamic-settings.store' => null,
        'dynamic-settings.update' => null,
        'dynamic-settings.destroy' => null,

        'translations.index' => null,
        'translations.show' => null,
        'translations.store' => null,
        'translations.update' => null,
        'translations.destroy' => null,

        'files.index' => null,
        'files.show' => null,
        'files.store' => null,
        'files.update' => null,
        'files.destroy' => null,
    ];

    /**
     * Set Custom Authorization check
     *
     * @param string $endpointName
     * @param callable $customAuthorization
     *  - 1st param will be the FormRequest
     *  - You must be a boolean
     *
     * @return void
     */
    public static function setCustomAuthorization(
        string $endpointName,
        callable $customAuthorization
    ): void {
        ReadyAuthorization::$customAuthorizations[$endpointName] = $customAuthorization;
    }

    public static function getAuthorization(string $endpointName): Closure
    {
        return (ReadyAuthorization::$customAuthorizations[$endpointName] ?? fn () => true)
            ?: fn () => true;
    }
}
