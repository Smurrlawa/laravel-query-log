<?php

namespace Smurrlawa\QueryLogger;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class QueryLoggerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/query-logger.php', 'query-logger');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/query-logger.php' => $this->app->configPath('query-logger.php'),
            ], 'config');
        }

        $this->registerQueryListenerIfEnabled();
    }

    protected function registerQueryListenerIfEnabled(): void
    {
        $config = config('query-logger');

        if (
            empty($config['enabled']) ||
            ! in_array($this->app->environment(), $config['environments'] ?? [], true)
        ) {
            return;
        }

        if(empty($config['channel'])) {
            throw new \InvalidArgumentException('Query logger channel must be specified in the configuration.');
        }

        DB::listen(function (QueryExecuted $query) use ($config) {
            Log::channel($config['channel'])->debug('Query executed:', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time_ms' => $query->time,
            ]);
        });
    }
}
