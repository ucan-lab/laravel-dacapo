<?php

namespace UcanLab\LaravelDacapo\Test;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Migrations\DacapoGenerator;
use UcanLab\LaravelDacapo\Test\Storage\SchemasMockStorage;
use UcanLab\LaravelDacapo\Test\Storage\MigrationsMockStorage;

class DacapoGenerateTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param SchemasMockStorage $schemasStorage
     * @param MigrationsMockStorage $originStorage
     */
    public function testResolve(SchemasMockStorage $schemasStorage, MigrationsMockStorage $originStorage): void
    {
        $tempStorage = $this->makeTempMigrationStorage();
        (new DacapoGenerator($schemasStorage, $tempStorage))->run();

        foreach ($tempStorage->getFiles() as $file) {
            $this->assertFileEquals($originStorage->getPath($file->getFilename()), $file->getPathname());
        }

        $this->assertSame($originStorage->getFiles()->count(), $tempStorage->getFiles()->count());
    }

    /**
     * dataProvider.
     */
    public function dataProvider(): array
    {
        $this->createApplication();

        $data = [];
        foreach ($this->getTestDirectories() as $directoryPath) {
            $dirName = basename($directoryPath);
            $data[$dirName] = [
                'schemasStorage' => new SchemasMockStorage($directoryPath . '/schemas'),
                'migrationsStorage' => new MigrationsMockStorage($directoryPath . '/migrations'),
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    private function getTestDirectories(): array
    {
        return File::directories(__DIR__ . '/Storage');
    }

    /**
     * @return MigrationsMockStorage
     */
    private function makeTempMigrationStorage(): MigrationsMockStorage
    {
        $storage = new MigrationsMockStorage($this->getTempMigrationPath());

        if ($storage->exists()) {
            $storage->deleteDirectory();
        }

        $storage->makeDirectory();

        return $storage;
    }

    /**
     * @param string|null $path
     * @return string
     */
    private function getTempMigrationPath(?string $path = null): string
    {
        return sys_get_temp_dir() . '/migrations' . ($path ? "/$path" : '');
    }
}
