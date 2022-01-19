<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Port;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;

interface MigrationListRepository
{
    public function saveFileList(MigrationFileList $fileList): void;

    public function saveFile(MigrationFile $file): void;
}
