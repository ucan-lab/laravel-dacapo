<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoUninstallCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository());
        $this->artisan('dacapo:uninstall')->assertExitCode(0);
    }
}
