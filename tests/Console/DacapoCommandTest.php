<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\App\UseCase\Console;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFileList;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\App\UseCase\Builder\DatabaseBuilder;
use UcanLab\LaravelDacapo\App\UseCase\Builder\MysqlDatabaseBuilder;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemoryMigrationListRepository;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemorySchemaListRepository;
use UcanLab\LaravelDacapo\Providers\ConsoleServiceProvider;
use UcanLab\LaravelDacapo\Test\TestCase;

class DacapoCommandTest extends TestCase
{
    /**
     * @param MigrationFileList $expectedMigrationFileList
     * @param SchemaFileList $schemaFileList
     * @dataProvider dataResolve
     */
    public function testResolve(MigrationFileList $expectedMigrationFileList, SchemaFileList $schemaFileList): void
    {
        $this->app->register(ConsoleServiceProvider::class);

        $actualMigrationFileList = new MigrationFileList();
        $this->instance(DatabaseBuilder::class, new MysqlDatabaseBuilder());
        $this->instance(SchemaListRepository::class, new InMemorySchemaListRepository($schemaFileList));
        $this->instance(MigrationListRepository::class, new InMemoryMigrationListRepository($actualMigrationFileList));
        $this->artisan('dacapo')->assertExitCode(0);

        $this->assertMigrationFileList($expectedMigrationFileList, $actualMigrationFileList);
    }

    /**
     * @return array
     */
    public function dataResolve(): array
    {
        $this->createApplication();

        $data = [];
        $dirs = File::directories(__DIR__ . '/DacapoCommand');

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
