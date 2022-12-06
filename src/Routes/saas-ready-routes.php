<?php

use Illuminate\Support\Facades\Route;
use SaasReady\Http\Controllers\CurrencyController;

Route::prefix(config('saas-ready.route-prefix'))
    ->middleware(config('saas-ready.middlewares'))
    ->group(function () {
        $enabledRoutes = config('saas-ready.route-enabled');

        if ($enabledRoutes['currencies']) {
            Route::resource('currencies', CurrencyController::class);
        }
    });
