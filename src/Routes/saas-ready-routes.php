<?php

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;
use SaasReady\Http\Controllers\CountryController;
use SaasReady\Http\Controllers\CurrencyController;
use SaasReady\Http\Controllers\EventController;
use SaasReady\Http\Controllers\LanguageController;
use SaasReady\Http\Controllers\TranslationController;

Route::prefix(config('saas-ready.route-prefix'))
    ->middleware([
        SubstituteBindings::class,
        ...config('saas-ready.middlewares'),
    ])
    ->group(function () {
        if (config('saas-ready.route-enabled.currencies')) {
            Route::resource('currencies', CurrencyController::class);
        }

        if (config('saas-ready.route-enabled.countries')) {
            Route::resource('countries', CountryController::class);
        }

        if (config('saas-ready.route-enabled.languages')) {
            Route::resource('languages', LanguageController::class);
        }

        if (config('saas-ready.route-enabled.events')) {
            Route::resource('events', EventController::class)
                ->only([
                    'index',
                    'show',
                ]);
        }

        if (config('saas-ready.route-enabled.translations')) {
            Route::resource('languages', TranslationController::class);
        }
    });
