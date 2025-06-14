<?php

declare(strict_types=1);

namespace Smurrlawa\QueryLogger\Loggers;

use Illuminate\Support\Facades\Log;
use Smurrlawa\QueryLogger\Contracts\QueryLogger;

final readonly class GlobalQueryLogger implements QueryLogger
{
    /**
     * @param string $sql
     * @param array $bindings
     * @param float $time
     * @return void
     */
    public function log(string $sql, array $bindings, float $time): void
    {
        if (!$this->isEnabled()) {
            return;
        }

        $logChannel = $this->getChannel();

        Log::channel($logChannel)->debug('Query executed:', [
            'sql' => $sql,
            'bindings' => $bindings,
            'time_ms' => $time,
        ]);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        if (!config('query-logger.enabled', true)) {
            return false;
        }

        if (!in_array(app()->environment(), config('query-logger.environments', []), true)) {
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
