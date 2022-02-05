<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\Application\UseCase\Console;

use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder\MysqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\Builder\PostgresqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemoryDatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;
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
        $this->app->register(ConsoleServiceProvider::class);

        $this->instance(DatabaseBuilder::class, new MysqlDatabaseBuilder());
        $this->instance(DatabaseMigrationsStorage::class, $databaseMigrationsStorage = new InMemoryDatabaseMigrationsStorage());

        $this->mock(DatabaseSchemasStorage::class, function (MockInterface $mock) use ($schemas): void {
            $mock->shouldReceive('getFilePathList')->andReturn(
                array_map(fn ($f) => $f->getRealPath(), File::files($schemas))
            );
        });

        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($migrations, $databaseMigrationsStorage);
    }

    /**
     * @return array
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
        $this->app->register(ConsoleServiceProvider::class);

        $this->instance(DatabaseBuilder::class, new PostgresqlDatabaseBuilder());
        $this->instance(DatabaseMigrationsStorage::class, $databaseMigrationsStorage = new InMemoryDatabaseMigrationsStorage());

        $this->mock(DatabaseSchemasStorage::class, function (MockInterface $mock) use ($schemas): void {
            $mock->shouldReceive('getFilePathList')->andReturn(
                array_map(fn ($f) => $f->getRealPath(), File::files($schemas))
            );
        });

        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($migrations, $databaseMigrationsStorage);
    }

    /**
     * @return array
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

        $this->assertSame(count($expectedMigrationFileList), count($actualMigrationFileList));

        for ($i = 0; $i < count($expectedMigrationFileList); $i++) {
            $expectedFile = $expectedMigrationFileList[$i];
            $actualFile = $actualMigrationFileList[$i];

            $this->assertSame(basename($expectedFile), $actualFile['fileName']);
            $this->assertSame(file_get_contents($expectedFile), $actualFile['fileContents']);
        }
    }
}
