<?php

return [
    /**
     * A list of middlewares you want to register for all the endpoints of Laravel SaaS
     *
     * Usage tips: permission checking, pre-data handling,...
     */
    'middlewares' => [
        // 'web',
        // YourMiddleware::class,
    ],

    /**
     * Prefix of the generic routes
     * Eg:
     * - saas/countries
     * - saas/currencies
     * ...
     */
    'route-prefix' => 'saas',

    /**
     * Turn On/Off for the generic routes
     */
    'route-enabled' => [
        'currencies' => true,
        'countries' => true,
        'languages' => true,
    ],

    /**
     * Event sourcing configurations
     */
    'event-sourcing' => [
        /**
         * If turned on, the listener will be pushed to Queue
         * By default, it will run on current thead
         */
        'should-queue' => false,

        /**
         * Queue Name config (->onQueue(...))
         *
         * `null` for default
         */
        'queue-name' => null,

        /**
         * Queue Connection config (->onConnection(...))
         *
         * `null` for default
         */
        'queue-connection' => null,

        /**
         * User class for relationship registration
         *
         * @see \SaasReady\Models\Event::user()
         */
        'user-model' => \Illuminate\Foundation\Auth\User::class,
    ],
];
