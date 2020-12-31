<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemoryMigrationListRepository;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository());
        $this->instance(MigrationListRepository::class, new InMemoryMigrationListRepository());
        $this->artisan('dacapo')->assertExitCode(0);
    }
}
