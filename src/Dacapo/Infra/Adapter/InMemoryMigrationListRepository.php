<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;

class InMemoryMigrationListRepository implements MigrationListRepository
{
    protected MigrationFileList $migrationFileList;

    /**
     * InMemoryMigrationListRepository constructor.
     * @param MigrationFileList $migrationFileList
     */
    public function __construct(MigrationFileList $migrationFileList)
    {
        $this->migrationFileList = $migrationFileList;
    }

    /**
     * @param MigrationFileList $fileList
     */
    public function saveFileList(MigrationFileList $fileList): void
    {
        foreach ($fileList as $file) {
            $this->migrationFileList->add($file);
        }
    }

    /**
     * @param MigrationFile $file
     */
    public function saveFile(MigrationFile $file): void
    {
        $this->migrationFileList->add($file);
    }
}
