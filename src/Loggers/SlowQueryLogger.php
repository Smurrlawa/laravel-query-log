<?php

declare(strict_types=1);

namespace Smurrlawa\QueryLogger\Loggers;

use Illuminate\Support\Facades\Log;
use Smurrlawa\QueryLogger\Contracts\QueryLogger;

final readonly class SlowQueryLogger implements QueryLogger
{
    /**
     * @param string $sql
     * @param array $bindings
     * @param float $time
     * @return void
     */
    public function log(string $sql, array $bindings, float $time): void
    {
        if (! $this->isEnabled()) {
            return;
        }

        if ($time < config('query-logger.slow_queries_threshold')) {
            return;
        }

        $logChannel = $this->getChannel();

        Log::channel($logChannel)->warning('Slow query executed:', [
            'sql' => $sql,
            'bindings' => $bindings,
            'time_ms' => $time,
        ]);
    }

    public function isEnabled(): bool
    {
        if (! config('query-logger.slow_queries_enabled', true)) {
            return false;
        }

        if (config('query-logger.slow_queries_threshold', 1000) <= 0) {
            throw new \InvalidArgumentException('Slow queries threshold must be greater than 0.');
        }

        if (! in_array(app()->environment(), config('query-logger.environments', []), true)) {
            return false;
        }

        return true;
    }

    public function getChannel(): string
    {
        if (empty(config('query-logger.channel'))) {
            throw new \InvalidArgumentException('Query logger channel must be specified in the configuration.');
        }

        return config('query-logger.channel');
    }
}
