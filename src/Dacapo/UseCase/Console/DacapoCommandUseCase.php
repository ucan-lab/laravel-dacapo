<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Console;

use DateTime;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
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
     * @param DateTime $prefixDate
     * @return MigrationFileList
     */
    public function handle(DateTime $prefixDate): MigrationFileList
    {
        return $this->generator->generate($prefixDate, $this->repository->get());
    }
}
