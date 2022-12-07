<?php

use Illuminate\Support\Facades\Route;
use SaasReady\Http\Controllers\CurrencyController;

Route::prefix(config('saas-ready.route-prefix'))
    ->middleware(config('saas-ready.middlewares'))
    ->group(function () {
        if (config('saas-ready.route-enabled.currencies')) {
            Route::resource('currencies', CurrencyController::class);
        }
    });
