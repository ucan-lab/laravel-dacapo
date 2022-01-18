<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Application\Console;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFileList;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoInitCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository(new SchemaFileList()));
        $this->artisan('dacapo:init')->assertExitCode(0);
    }
}
