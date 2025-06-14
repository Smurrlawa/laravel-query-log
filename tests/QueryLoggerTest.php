<?php

namespace Smurrlawa\QueryLogger\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery;
use Orchestra\Testbench\TestCase;
use Smurrlawa\QueryLogger\QueryLoggerServiceProvider;

class QueryLoggerTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            QueryLoggerServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['env'] = 'testing';

        $app['config']->set('query-logger.enabled', true);
        $app['config']->set('query-logger.environments', ['testing']);
        $app['config']->set('query-logger.channel', 'single');
    }

    public function testQueryLoggingIsEnabledInTestingEnvironment(): void
    {
        $mockChannel = \Mockery::mock();

        Log::shouldReceive('channel')
            ->once()
            ->with('single')
            ->andReturn($mockChannel);

        $mockChannel->shouldReceive('debug')
            ->once()
            ->with('Query executed:', \Mockery::on(function ($data) {
                return isset($data['sql'], $data['bindings'], $data['time_ms']);
            }));

        DB::select('SELECT 1');
    }

}
