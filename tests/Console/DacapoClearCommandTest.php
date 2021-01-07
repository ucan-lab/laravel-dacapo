<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemoryMigrationListRepository;
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
            ->expectsOutput('1970_01_01_000000_create_failed_jobs_table.php is deleted.')
            ->expectsOutput('1970_01_01_000000_create_password_resets_table.php is deleted.')
            ->expectsOutput('1970_01_01_000000_create_users_table.php is deleted.')
            ->assertExitCode(0);
    }
}
