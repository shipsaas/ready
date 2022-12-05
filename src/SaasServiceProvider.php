<?php

namespace SaasReady;

use Illuminate\Support\ServiceProvider;

class SaasServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Configs/saas-ready.php', 'saas-ready');

        $this->publishes([
            __DIR__ . '/Configs/saas-ready.php',
        ], 'saas-ready');
    }
}
