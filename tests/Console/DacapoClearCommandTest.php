<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Console;

use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

final class DacapoClearCommandTest extends TestCase
{
    public function testResolve(): void
    {
        $this->register(ConsoleServiceProvider::class);

        file_put_contents(database_path('migrations/1970_01_01_000000_create_users_table.php'), '');
        file_put_contents(database_path('migrations/1970_01_01_000000_create_password_resets_table.php'), '');
        file_put_contents(database_path('migrations/1970_01_01_000000_create_failed_jobs_table.php'), '');

        $this->artisan('dacapo:clear')
            ->assertExitCode(0);

        $this->assertFileDoesNotExist(database_path('migrations/1970_01_01_000000_create_users_table.php'));
        $this->assertFileDoesNotExist(database_path('migrations/1970_01_01_000000_create_password_resets_table.php'));
        $this->assertFileDoesNotExist(database_path('migrations/1970_01_01_000000_create_failed_jobs_table.php'));
    }
}
