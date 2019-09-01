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
     * @param string $dir
     * @param array $files
     */
    public function testResolve(string $dir, array $files): void
    {
        $schemasStorage = new SchemasMockStorage($dir);
        $migrationsStorage = new MigrationsMockStorage();

        (new DacapoGenerator($schemasStorage, $migrationsStorage))->run();

        foreach ($files as $file) {
            $this->assertFileExists($migrationsStorage->getPath($file));
            $this->assertFileEquals($migrationsStorage->getPath($file), $schemasStorage->getPath($file));
        }

        $this->assertSame($migrationsStorage->getFiles()->count(), count($files));
    }

    /**
     * dataProvider
     */
    public function dataProvider(): array
    {
        $this->createApplication();

        $data = [];
        foreach ($this->getDirectories() as $directoryPath) {
            $dir = basename($directoryPath);
            $data[$dir] = [
                'dir' => $dir,
                'files' => $this->getMigrationFileNames($dir),
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
