<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Presentation\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DacapoMakeFactoriesCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->artisan('dacapo:make:factories')->assertExitCode(0);
    }
}
