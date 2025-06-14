<?php

declare(strict_types=1);

namespace Smurrlawa\QueryLogger;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Smurrlawa\QueryLogger\Contracts\QueryLogger;
use Smurrlawa\QueryLogger\Loggers\GlobalQueryLogger;
use Smurrlawa\QueryLogger\Loggers\SlowQueryLogger;

class QueryLoggerServiceProvider extends ServiceProvider
{
    protected GlobalQueryLogger $globalQueryLogger;
    protected SlowQueryLogger $slowQueryLogger;

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/query-logger.php', 'query-logger');
    }

    /**
     * @throws BindingResolutionException
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/query-logger.php' => $this->app->configPath('query-logger.php'),
            ], 'config');
        }

        $this->globalQueryLogger = $this->app->make(GlobalQueryLogger::class);
        $this->slowQueryLogger = $this->app->make(SlowQueryLogger::class);

        $this->registerLoggers();
    }

    protected function registerLoggers(): void
    {
        DB::listen(function (QueryExecuted $query) {
            $this->logQuery($this->slowQueryLogger, $query);
            $this->logQuery($this->globalQueryLogger, $query);
        });
    }

    protected function logQuery(QueryLogger $logger, QueryExecuted $query): void
    {
        $logger->log(
            sql: $query->sql,
            bindings: $query->bindings,
            time: $query->time
        );
    }
}
