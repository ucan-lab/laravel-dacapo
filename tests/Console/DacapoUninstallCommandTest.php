<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\PrefixDateTime;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFileList;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoUninstallCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->instance(PrefixDateTime::class, new PrefixDateTime());
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository(new SchemaFileList()));
        $this->artisan('dacapo:uninstall')->assertExitCode(0);
    }
}
