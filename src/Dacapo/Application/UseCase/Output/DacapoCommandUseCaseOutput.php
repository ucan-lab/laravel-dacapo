<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output;

use UcanLab\LaravelDacapo\Dacapo\Domain\Migration\MigrationFileList;

class DacapoCommandUseCaseOutput
{
    public MigrationFileList $migrationFileList;

    /**
     * @param MigrationFileList $migrationFileList
     */
    public function __construct(MigrationFileList $migrationFileList)
    {
        $this->migrationFileList = $migrationFileList;
    }
}
