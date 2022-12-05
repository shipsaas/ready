<?php

namespace SaasReady;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Listeners\EventSourcingListener;

class SaasServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Configs/saas-ready.php', 'saas-ready');

        $this->publishes([
            __DIR__ . '/Configs/saas-ready.php',
        ], 'saas-ready');

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/saas-ready-routes.php');

        Event::listen(EventSourcingContract::class, EventSourcingListener::class);
    }
}
