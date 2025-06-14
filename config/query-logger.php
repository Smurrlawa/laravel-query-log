<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Query Logger Enabled
    |--------------------------------------------------------------------------
    | Specify in which environments the query logger should run.
    */
    'enabled' => env('QUERY_LOGGER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Log Channel
    |--------------------------------------------------------------------------
    | Either specify a log channel (from config/logging.php)
    | or provide a fully qualified class name implementing Psr\Log\LoggerInterface
    */
    'channel' => env('QUERY_LOGGER_CHANNEL', 'daily'),

    /*
    |--------------------------------------------------------------------------
    | Slow Queries Enabled
    |--------------------------------------------------------------------------
    | Enable or disable the logging of slow queries.
     */
    'slow_queries_enabled' => env('QUERY_LOGGER_SLOW_QUERIES_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Slow Queries Threshold
    |--------------------------------------------------------------------------
    | Specify the threshold in milliseconds for slow queries.
     */
    'slow_queries_threshold' => env('QUERY_LOGGER_SLOW_QUERIES_THRESHOLD', 1000),

    /*
    |--------------------------------------------------------------------------
    | Environments
    |--------------------------------------------------------------------------
    | Specify in which environments the query logger should run.
    */
    'environments' => ['local', 'staging'],

];
