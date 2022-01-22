<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseMigrationsStorage;

final class InMemoryDatabaseMigrationsStorage implements DatabaseMigrationsStorage
{
    public array $fileList = [];

    /**
     * @param string $fileName
     * @param string $fileContents
     */
    public function saveFile(string $fileName, string $fileContents): void
    {
        $this->fileList[] = ['fileName' => $fileName, 'fileContents' => $fileContents];
    }
}
