<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\SchemaFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\MysqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Builder\PostgresqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemoryMigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoCommandTest extends TestCase
{
    /**
     * @param MigrationFileList $expectedMigrationFileList
     * @param SchemaFileList $schemaFileList
     * @dataProvider dataMysql
     */
    public function testMysql(MigrationFileList $expectedMigrationFileList, SchemaFileList $schemaFileList): void
    {
        $this->app->register(ConsoleServiceProvider::class);

        $actualMigrationFileList = new MigrationFileList();
        $this->instance(DatabaseBuilder::class, new MysqlDatabaseBuilder());
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository($schemaFileList));
        $this->instance(MigrationListRepository::class, new InMemoryMigrationListRepository($actualMigrationFileList));
        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($expectedMigrationFileList, $actualMigrationFileList);
    }

    /**
     * @return array
     */
    public function dataMysql(): array
    {
        $this->createApplication();

        $data = [];
        $dirs = File::directories(__DIR__ . '/DacapoCommand/mysql');

        foreach ($dirs as $dir) {
            [$migrations, $schemas] = File::directories($dir);

            $expectedMigrationFileList = new MigrationFileList();

            foreach (File::files($migrations) as $file) {
                $expectedMigrationFileList->add(new MigrationFile($file->getFilename(), $file->getContents()));
            }

            $schemaFileList = new SchemaFileList();

            foreach (File::files($schemas) as $file) {
                $schemaFileList->add(new SchemaFile($file->getFilename(), $file->getContents()));
            }

            $data[basename($dir)] = [
                'expectedMigrationFileList' => $expectedMigrationFileList,
                'schemaFileList' => $schemaFileList,
            ];
        }

        return $data;
    }

    /**
     * @param MigrationFileList $expectedMigrationFileList
     * @param SchemaFileList $schemaFileList
     * @dataProvider dataPostgresql
     */
    public function testPostgresql(MigrationFileList $expectedMigrationFileList, SchemaFileList $schemaFileList): void
    {
        $this->app->register(ConsoleServiceProvider::class);

        $actualMigrationFileList = new MigrationFileList();
        $this->instance(DatabaseBuilder::class, new PostgresqlDatabaseBuilder());
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository($schemaFileList));
        $this->instance(MigrationListRepository::class, new InMemoryMigrationListRepository($actualMigrationFileList));
        $this->artisan('dacapo --no-migrate')->assertExitCode(0);

        $this->assertMigrationFileList($expectedMigrationFileList, $actualMigrationFileList);
    }

    /**
     * @return array
     */
    public function dataPostgresql(): array
    {
        $this->createApplication();

        $data = [];
        $dirs = File::directories(__DIR__ . '/DacapoCommand/postgresql');

        foreach ($dirs as $dir) {
            [$migrations, $schemas] = File::directories($dir);

            $expectedMigrationFileList = new MigrationFileList();

            foreach (File::files($migrations) as $file) {
                $expectedMigrationFileList->add(new MigrationFile($file->getFilename(), $file->getContents()));
            }

            $schemaFileList = new SchemaFileList();

            foreach (File::files($schemas) as $file) {
                $schemaFileList->add(new SchemaFile($file->getFilename(), $file->getContents()));
            }

            $data[basename($dir)] = [
                'expectedMigrationFileList' => $expectedMigrationFileList,
                'schemaFileList' => $schemaFileList,
            ];
        }

        return $data;
    }

    /**
     * @param MigrationFileList $expected
     * @param MigrationFileList $actual
     */
    protected function assertMigrationFileList(MigrationFileList $expected, MigrationFileList $actual): void
    {
        $this->assertSame($expected->count(), $actual->count());

        $expectedIterator = $expected->getIterator();
        $actualIterator = $actual->getIterator();

        for ($i = 0; $i < $expected->count(); $i++) {
            $expectedFile = $expectedIterator->current();
            $actualFile = $actualIterator->current();

            $this->assertSame($expectedFile->getName(), $actualFile->getName());
            $this->assertSame($expectedFile->getContents(), $actualFile->getContents());

            $expectedIterator->next();
            $actualIterator->next();
        }
    }
}
