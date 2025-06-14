<?php

return [

    'enabled' => env('QUERY_LOGGER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Environments
    |--------------------------------------------------------------------------
    | Specify in which environments the query logger should run.
    */
    'environments' => ['local', 'staging'],

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    | Either specify a log channel (from config/logging.php)
    | or provide a fully qualified class name implementing Psr\Log\LoggerInterface
    */
    'channel' => env('QUERY_LOGGER_CHANNEL', 'daily'),

];
