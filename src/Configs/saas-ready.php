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
];
