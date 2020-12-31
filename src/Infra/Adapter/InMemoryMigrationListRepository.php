<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;

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
     * @param MigrationFile $file
     * @return bool
     */
    public function delete(MigrationFile $file): bool
    {
        return true;
    }

    /**
     * @param MigrationFile $file
     */
    public function saveFile(MigrationFile $file): void
    {
        $this->migrationFileList->add($file);
    }
}
