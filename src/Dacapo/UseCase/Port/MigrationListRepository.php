<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Port;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;

interface MigrationListRepository
{
    public function getFiles(): MigrationFileList;

    public function saveFileList(MigrationFileList $fileList): void;

    public function saveFile(MigrationFile $file): void;

    public function delete(MigrationFile $file): bool;
}
