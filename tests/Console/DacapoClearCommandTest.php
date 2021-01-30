<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemoryMigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoClearCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->instance(MigrationListRepository::class, new InMemoryMigrationListRepository(new MigrationFileList([
            new MigrationFile('1970_01_01_000000_create_users_table.php', ''),
            new MigrationFile('1970_01_01_000000_create_password_resets_table.php', ''),
            new MigrationFile('1970_01_01_000000_create_failed_jobs_table.php', ''),
        ])));

        $this->artisan('dacapo:clear')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_failed_jobs_table.php')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_password_resets_table.php')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_users_table.php')
            ->assertExitCode(0);
    }
}
