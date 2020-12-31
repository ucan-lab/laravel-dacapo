<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;

class DacapoClearCommandUseCase
{
    protected MigrationListRepository $repository;

    /**
     * DacapoClearCommandUseCase constructor.
     * @param MigrationListRepository $repository
     */
    public function __construct(MigrationListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return MigrationFileList
     */
    public function handle(): MigrationFileList
    {
        $files = $this->repository->getFiles();

        foreach ($files as $file) {
            $this->repository->delete($file);
        }

        return $files;
    }
}
