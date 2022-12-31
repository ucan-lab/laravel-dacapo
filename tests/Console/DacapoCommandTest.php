<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\MysqlDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Driver\PostgresqlDatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemoryDatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\LaravelDatabaseSchemasStorage;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseSchemasStorage;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;
use function count;

final class DacapoCommandTest extends TestCase
{
    /**
     * @param string $schemas
     * @param string $migrations
     * @dataProvider dataMysql
     */
    public function testMysql(string $schemas, string $migrations): void
    {
        $this->register(ConsoleServiceProvider::class);

        $this->instance(DatabaseDriver::class, new MysqlDatabaseDriver());
        $this->instance(DatabaseMigrationsStorage::class, $databaseMigrationsStorage = new InMemoryDatabaseMigrationsStorage());
        $this->instance(DatabaseSchemasStorage::class, new LaravelDatabaseSchemasStorage(new Filesystem(), $schemas));

        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($migrations, $databaseMigrationsStorage);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function dataMysql(): array
    {
        $this->createApplication();

        $data = [];
        $dirs = File::directories(__DIR__ . '/DacapoCommandTest/mysql');

        foreach ($dirs as $dir) {
            [$migrations, $schemas] = File::directories($dir);

            $data[basename($dir)] = [
                'schemas' => $schemas,
                'migrations' => $migrations,
            ];
        }

        return $data;
    }

    /**
     * @param string $schemas
     * @param string $migrations
     * @dataProvider dataPostgresql
     */
    public function testPostgresql(string $schemas, string $migrations): void
    {
        $this->register(ConsoleServiceProvider::class);

        $this->instance(DatabaseDriver::class, new PostgresqlDatabaseDriver());
        $this->instance(DatabaseMigrationsStorage::class, $databaseMigrationsStorage = new InMemoryDatabaseMigrationsStorage());
        $this->instance(DatabaseSchemasStorage::class, new LaravelDatabaseSchemasStorage(new Filesystem(), $schemas));

        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($migrations, $databaseMigrationsStorage);
    }

    /**
     * @return array<string, array<string, string>>
     */
    public function dataPostgresql(): array
    {
        $this->createApplication();

        $data = [];
        $dirs = File::directories(__DIR__ . '/DacapoCommandTest/postgresql');

        foreach ($dirs as $dir) {
            [$migrations, $schemas] = File::directories($dir);

            $data[basename($dir)] = [
                'schemas' => $schemas,
                'migrations' => $migrations,
            ];
        }

        return $data;
    }

    /**
     * @param string $migrations
     * @param InMemoryDatabaseMigrationsStorage $databaseMigrationsStorage
     */
    private function assertMigrationFileList(string $migrations, InMemoryDatabaseMigrationsStorage $databaseMigrationsStorage): void
    {
        $expectedMigrationFileList = array_map(fn ($f) => $f->getRealPath(), File::files($migrations));

        $actualMigrationFileList = $databaseMigrationsStorage->fileList;
        $ids = array_column($actualMigrationFileList, 'fileName');
        array_multisort($ids, SORT_ASC, $actualMigrationFileList);

        $this->assertSame(count($expectedMigrationFileList), count($actualMigrationFileList));

        for ($i = 0; $i < count($expectedMigrationFileList); $i++) {
            $expectedFile = $expectedMigrationFileList[$i];
            $actualFile = $actualMigrationFileList[$i];

            $this->assertSame(basename((string) $expectedFile), $actualFile['fileName']);
            $this->assertSame(file_get_contents((string) $expectedFile), $actualFile['fileContents']);
        }
    }
}
