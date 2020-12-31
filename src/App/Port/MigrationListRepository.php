<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFile;

interface MigrationListRepository
{
    public function getFiles(): array;

    public function saveFile(MigrationFile $file): void;

    public function delete(string $name): bool;
}
