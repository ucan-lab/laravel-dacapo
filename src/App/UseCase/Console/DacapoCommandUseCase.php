<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\App\UseCase\Generator\MigrationGenerator;

class DacapoCommandUseCase
{
    protected SchemaListRepository $repository;
    protected MigrationGenerator $generator;

    /**
     * DacapoCommandUseCase constructor.
     * @param SchemaListRepository $repository
     * @param MigrationGenerator $generator
     */
    public function __construct (SchemaListRepository $repository, MigrationGenerator $generator)
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
