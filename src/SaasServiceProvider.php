<?php

namespace SaasReady;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use SaasReady\Contracts\EventSourcingContract;
use SaasReady\Contracts\TranslationRepositoryContract;
use SaasReady\Listeners\EventSourcingListener;
use SaasReady\Models\Country;
use SaasReady\Models\Currency;
use SaasReady\Models\Event as EventModel;
use SaasReady\Services\TranslationRepositories\CacheTranslationRepository;
use SaasReady\Services\TranslationRepositories\DatabaseTranslationRepository;

class SaasServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        AboutCommand::add('ShipSaaS/Ready', fn () => ['Version' => '0.0.1']);

        $this->mergeConfigFrom(__DIR__ . '/Configs/saas-ready.php', 'saas-ready');

        $this->publishes([
            __DIR__ . '/Configs/saas-ready.php',
        ], 'saas-ready');

        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/Routes/saas-ready-routes.php');

        Event::listen(EventSourcingContract::class, function (EventSourcingContract $event) {
            if (!config('saas-ready.event-sourcing.should-queue')) {
                EventSourcingListener::dispatchSync($event);

                return;
            }

            EventSourcingListener::dispatch($event)
                ->onQueue(config('saas-ready.event-sourcing.queue-name'))
                ->onConnection(config('saas-ready.event-sourcing.queue-connection'));
        });

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'SaasReady\\Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });

        Route::model('currency', Currency::class);
        Route::model('country', Country::class);
        Route::model('event', EventModel::class);
    }

    public function register(): void
    {
        $this->app->singleton(DatabaseTranslationRepository::class);
        $this->app->singleton(CacheTranslationRepository::class);

        $this->app->bind(TranslationRepositoryContract::class, function () {
            if (config('saas-ready.translation.should-cache')) {
                return $this->app->make(CacheTranslationRepository::class);
            }

            return $this->app->make(DatabaseTranslationRepository::class);
        });
    }
}
