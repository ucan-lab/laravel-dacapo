<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Port\SchemaListRepository;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;

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
     * @return MigrationFileList
     */
    public function handle(): MigrationFileList
    {
        return $this->generator->generate($this->repository->get());
    }
}
