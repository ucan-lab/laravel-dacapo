<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;

class DacapoUninstallCommandUseCase
{
    protected SchemaListRepository $repository;

    /**
     * DacapoUninstallCommandUseCase constructor.
     * @param SchemaListRepository $repository
     */
    public function __construct(SchemaListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        return $this->repository->clear();
    }
}
