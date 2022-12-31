<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Presentation\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DacapoUninstallCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->register(ConsoleServiceProvider::class);
        $this->artisan('dacapo:uninstall')->assertExitCode(0);
    }
}
