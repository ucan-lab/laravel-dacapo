<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;

class DacapoInitCommandUseCase
{
    protected SchemaListRepository $repository;

    /**
     * DacapoInitCommandUseCase constructor.
     * @param SchemaListRepository $repository
     */
    public function __construct(SchemaListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $version
     * @return bool
     */
    public function handle(string $version): bool
    {
        $this->repository->makeDirectory();
        $this->repository->saveFile('default.yml', $this->repository->getLaravelDefaultSchemaFile($version));

        return true;
    }
}
