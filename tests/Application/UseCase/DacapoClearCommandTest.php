<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Application\UseCase\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoClearCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->app->register(ConsoleServiceProvider::class);

        file_put_contents($this->app->databasePath('migrations/1970_01_01_000000_create_users_table.php'), '');
        file_put_contents($this->app->databasePath('migrations/1970_01_01_000000_create_password_resets_table.php'), '');
        file_put_contents($this->app->databasePath('migrations/1970_01_01_000000_create_failed_jobs_table.php'), '');

        $this->artisan('dacapo:clear')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_failed_jobs_table.php')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_password_resets_table.php')
            ->expectsOutput('Deleted: 1970_01_01_000000_create_users_table.php')
            ->assertExitCode(0);
    }
}
