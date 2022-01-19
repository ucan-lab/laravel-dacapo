<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use Exception;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input\DacapoCommandUseCaseInput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;

class DacapoCommandUseCase
{
    protected MigrationGenerator $generator;

    /**
     * DacapoCommandUseCase constructor.
     * @param MigrationGenerator $generator
     */
    public function __construct(MigrationGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param DacapoCommandUseCaseInput $input
     * @return DacapoCommandUseCaseOutput
     * @throws Exception
     */
    public function handle(DacapoCommandUseCaseInput $input): DacapoCommandUseCaseOutput
    {
        $schemaList = new SchemaList();

        foreach ($input->schemaFiles as $tableName => $tableAttributes) {
            $schemaList->add(Schema::factoryFromYaml($tableName, $tableAttributes));
        }

        $migrationFileList = $this->generator->generate($schemaList);

        return new DacapoCommandUseCaseOutput($migrationFileList);
    }
}
