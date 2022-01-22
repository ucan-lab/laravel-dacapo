<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Application\UseCase\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DacapoUninstallCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->artisan('dacapo:uninstall')->assertExitCode(0);
    }
}
