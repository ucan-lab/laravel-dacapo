<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage;

use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

interface DatabaseMigrationsStorage
{
    public function save(MigrationFile $migrationFile): void;
}
