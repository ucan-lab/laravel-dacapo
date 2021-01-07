<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;

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
     * @return MigrationFileList
     */
    public function getFiles(): MigrationFileList
    {
        return $this->migrationFileList;
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

    /**
     * @param MigrationFile $file
     * @return bool
     */
    public function delete(MigrationFile $file): bool
    {
        return true;
    }
}
