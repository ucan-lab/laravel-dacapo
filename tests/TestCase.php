<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test;

use Illuminate\Testing\PendingCommand;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use RuntimeException;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Call artisan command and return code.
     *
     * @param string $command
     * @param array<string, mixed> $parameters
     */
    final public function artisan($command, $parameters = []): PendingCommand
    {
        if ($this->app === null) {
            throw new RuntimeException('Application is null');
        }

        return new PendingCommand($this, $this->app, $command, $parameters);
    }

    /**
     * Register a service provider with the application.
     *
     * @throws RuntimeException
     */
    final public function register(string $provider, bool $force = false): void
    {
        if ($this->app === null) {
            throw new RuntimeException('Application is null');
        }

        $this->app->register($provider, $force);
    }
}
