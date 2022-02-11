<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test;

use Illuminate\Testing\PendingCommand;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Call artisan command and return code.
     *
     * @param string $command
     * @param array<string, mixed> $parameters
     * @return PendingCommand
     */
    public function artisan($command, $parameters = []): PendingCommand
    {
        return new PendingCommand($this, $this->app, $command, $parameters);
    }
}
