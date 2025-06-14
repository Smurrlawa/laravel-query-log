<?php

namespace Smurrlawa\QueryLogger\Contracts;

use InvalidArgumentException;

interface QueryLogger
{

    /**
     * Log a query execution.
     *
     * @param string $sql
     * @param array $bindings
     * @param float $time
     * @return void
     */
    public function log(string $sql, array $bindings, float $time): void;

    /**
     * Check if the query logger is enabled.
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Get the log channel.
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function getChannel(): string;

}