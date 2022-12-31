<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseMigrationsStorage;

final class InMemoryDatabaseMigrationsStorage implements DatabaseMigrationsStorage
{
    /**
     * @var array<int, array<string, string>>
     */
    public array $fileList = [];

    public function save(MigrationFile $migrationFile): void
    {
        $this->fileList[] = ['fileName' => $migrationFile->getName(), 'fileContents' => $migrationFile->getContents()];
    }
}
