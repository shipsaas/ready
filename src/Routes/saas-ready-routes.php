<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use SaasReady\Http\Controllers\CountryController;
use SaasReady\Http\Controllers\CurrencyController;
use SaasReady\Http\Controllers\DynamicSettingsController;
use SaasReady\Http\Controllers\EventController;
use SaasReady\Http\Controllers\LanguageController;
use SaasReady\Http\Controllers\ReleaseNoteController;
use SaasReady\Http\Controllers\TranslationController;

Route::prefix(config('saas-ready.route-prefix'))
    ->middleware([
        SubstituteBindings::class,
        ...config('saas-ready.middlewares'),
    ])
    ->group(function () {
        if (config('saas-ready.route-enabled.currencies')) {
            Route::resource('currencies', CurrencyController::class)
                ->except(['edit', 'create']);
        }

        if (config('saas-ready.route-enabled.countries')) {
            Route::resource('countries', CountryController::class)
                ->except(['edit', 'create']);
        }

        if (config('saas-ready.route-enabled.languages')) {
            Route::resource('languages', LanguageController::class)
                ->except(['edit', 'create']);
        }

        if (config('saas-ready.route-enabled.events')) {
            Route::resource('events', EventController::class)
                ->only([
                    'index',
                    'show',
                ]);
        }

        if (config('saas-ready.route-enabled.translations')) {
            Route::resource('translations', TranslationController::class)
                ->except(['edit', 'create']);
        }

        if (config('saas-ready.route-enabled.dynamic-settings')) {
            Route::resource('dynamic-settings', DynamicSettingsController::class)
                ->except(['edit', 'create'])
                ->parameter('dynamic-setting', 'dynamicSetting');
        }

        if (config('saas-ready.route-enabled.release-notes')) {
            Route::resource('release-notes', ReleaseNoteController::class)
                ->except(['edit', 'create'])
                ->parameter('release-note', 'releaseNote');
        }
    });
