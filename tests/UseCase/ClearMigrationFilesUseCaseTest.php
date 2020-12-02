<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Test\UseCase;

use UcanLab\LaravelDacapo\App\UseCase\ClearMigrationFilesUseCase;
use UcanLab\LaravelDacapo\Infra\Adapter\InMemoryMigrationsStorage;
use UcanLab\LaravelDacapo\Test\TestCase;

class ClearMigrationFilesUseCaseTest extends TestCase
{
    /**
     * @param array $files
     * @param $resolveFiles
     * @covers ClearMigrationFilesUseCase::handle
     * @dataProvider dataResolve
     */
    public function testResolve(array $files, $resolveFiles): void
    {
        $storage = new InMemoryMigrationsStorage($files);

        (new ClearMigrationFilesUseCase($storage))->handle();

        $this->assertSame($resolveFiles, $storage->getFiles());
    }

    /**
     * @return string[]
     */
    public function dataResolve(): array
    {
        return [
            'deleted' => [
                'files' => [
                    '1970_01_01_000000_create_users_table.php',
                    '1970_01_01_000000_create_password_resets_table.php',
                    '1970_01_01_000000_create_failed_jobs_table.php',
                ],
                'resolveFiles' => [
                ],
            ],
            'notDeleted' => [
                'files' => [
                    '2014_10_12_000000_create_users_table.php',
                    '2014_10_12_100000_create_password_resets_table.php',
                    '2019_08_19_000000_create_failed_jobs_table.php',
                ],
                'resolveFiles' => [
                    '2014_10_12_000000_create_users_table.php',
                    '2014_10_12_100000_create_password_resets_table.php',
                    '2019_08_19_000000_create_failed_jobs_table.php',
                ],
            ],
        ];
    }
}
