<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    | When debug mode is enabled, detailed error messages with stack traces
    | will be shown. Disable this in production!
    */
    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    */
    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    */
    'database' => [
        'driver' => 'pgsql',
        'host' => 'localhost',
        'port' => 5432,
        'database' => 'mvc_framework',
        'username' => 'postgres',
        'password' => '',
        'charset' => 'utf8',
    ],
];
