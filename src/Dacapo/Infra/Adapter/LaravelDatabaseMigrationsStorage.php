<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use Illuminate\Filesystem\Filesystem;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseMigrationsStorage;

final class LaravelDatabaseMigrationsStorage implements DatabaseMigrationsStorage
{
    public function __construct(private Filesystem $filesystem)
    {
    }

    public function save(MigrationFile $migrationFile): void
    {
        $this->filesystem->put(database_path('migrations/' . $migrationFile->getName()), $migrationFile->getContents());
    }
}
