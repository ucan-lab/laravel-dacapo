<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use Illuminate\Support\Str;
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
     * @return array
     */
    public function handle(): array
    {
        $deletedFiles = [];

        foreach ($this->repository->getFiles() as $fileName) {
            if ($this->isFileGeneratedByDacapo($fileName)) {
                if ($this->repository->delete($fileName)) {
                    $deletedFiles[] = $fileName;
                }
            }
        }

        return $deletedFiles;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    private function isFileGeneratedByDacapo(string $fileName): bool
    {
        return Str::startsWith($fileName, '1970_01_01');
    }
}
