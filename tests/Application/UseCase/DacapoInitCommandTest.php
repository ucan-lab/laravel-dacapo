<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Application\UseCase\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoInitCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->artisan('dacapo:init')->assertExitCode(0);
    }
}