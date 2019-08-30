<?php

namespace UcanLab\LaravelDacapo\Test;

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
        return [
            'Laravel Default Migration' => [
                'dir' => 'laravel_default',
                'files' => [
                    '1970_01_01_000000_create_password_resets_table.php',
                    '1970_01_01_000000_create_users_table.php',
                ],
            ],
            'Laravel Legacy Default Migration' => [
                'dir' => 'laravel_legacy_default',
                'files' => [
                    '1970_01_01_000000_create_password_resets_table.php',
                    '1970_01_01_000000_create_users_table.php',
                ],
            ],
        ];
    }
}
