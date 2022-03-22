<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Presentation\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DacapoMakeModelsCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->artisan('dacapo:make:models')->assertExitCode(0);
    }
}
