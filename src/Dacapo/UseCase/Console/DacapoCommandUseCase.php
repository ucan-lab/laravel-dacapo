<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Console;

use UcanLab\LaravelDacapo\Dacapo\UseCase\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\SchemaListRepository;

class DacapoCommandUseCase
{
    protected SchemaListRepository $repository;
    protected MigrationGenerator $generator;

    /**
     * DacapoCommandUseCase constructor.
     * @param SchemaListRepository $repository
     * @param MigrationGenerator $generator
     */
    public function __construct(SchemaListRepository $repository, MigrationGenerator $generator)
    {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    /**
     * @throws
     */
    public function handle(): void
    {
        $this->generator->generate($this->repository->get());
    }
}
