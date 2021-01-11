<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Console;

use Illuminate\Support\Str;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFile;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;

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
     * @param bool $isAll
     * @return MigrationFileList
     */
    public function handle(bool $isAll): MigrationFileList
    {
        $deletedFiles = new MigrationFileList();

        foreach ($this->repository->getFiles() as $file) {
            if ($isAll) {
                $this->repository->delete($file);
                $deletedFiles->add($file);
            } elseif ($this->isDacapoFileName($file)) {
                $this->repository->delete($file);
                $deletedFiles->add($file);
            }
        }

        return $deletedFiles;
    }

    /**
     * @param MigrationFile $file
     * @return bool
     */
    protected function isDacapoFileName(MigrationFile $file): bool
    {
        return Str::startsWith($file->getName(), '1970_01_01');
    }
}
