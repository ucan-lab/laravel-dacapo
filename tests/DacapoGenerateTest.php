<?php

namespace UcanLab\LaravelDacapo\Test;

use Illuminate\Support\Facades\File;
use UcanLab\LaravelDacapo\Migrations\DacapoGenerator;
use UcanLab\LaravelDacapo\Test\Storage\MigrationsMockStorage;
use UcanLab\LaravelDacapo\Test\Storage\SchemasMockStorage;

class DacapoGenerateTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param string $dirName
     * @param SchemasMockStorage $schemasStorage
     * @param MigrationsMockStorage $migrationsStorage
     */
    public function testResolve(string $dirName, SchemasMockStorage $schemasStorage, MigrationsMockStorage $migrationsStorage): void
    {
        $migrationsStorage->deleteDirectory();
        (new DacapoGenerator($schemasStorage, $migrationsStorage))->run();

        $originStorage = new MigrationsMockStorage($this->getStoragePath());
        foreach ($migrationsStorage->getFiles() as $file) {
            $this->assertFileEquals($file->getPath(), $originStorage->getPath($file));
        }

        $this->assertSame($migrationsStorage->getFiles()->count(), $originStorage->getFiles()->count());
    }

    /**
     * dataProvider
     */
    public function dataProvider(): array
    {
        $this->createApplication();

        $data = [];
        foreach ($this->getDirectories() as $directoryPath) {
            $dirName = basename($directoryPath);
            $data[$dirName] = [
                'dirName' => $dirName,
                'schemasStorage' => new SchemasMockStorage($directoryPath),
                'migrationsStorage' => new MigrationsMockStorage($directoryPath),
            ];
        }

        return $data;
    }

    /**
     * @return array
     */
    private function getDirectories(): array
    {
        return File::directories($this->getStoragePath());
    }

    /**
     * @param string $dir
     * @return array
     */
    private function getMigrationFileNames(string $dir): array
    {
        $files = [];
        foreach (File::files($this->getStoragePath($dir)) as $file) {
            if ($file->getExtension() === 'php') {
                $files[] = $file->getFilename();
            }
        }

        return $files;
    }

    /**
     * @param string|null $path
     * @return string
     */
    private function getStoragePath(?string $path = null): string
    {
        return __DIR__ . '/Storage' . ($path ? "/$path" : '');
    }
}
