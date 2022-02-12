<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Input\DacapoCommandUseCaseInput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\TableName;

final class DacapoCommandUseCase
{
    /**
     * DacapoCommandUseCase constructor.
     * @param MigrationGenerator $generator
     */
    public function __construct(
        private MigrationGenerator $generator
    ) {
    }

    /**
     * @param DacapoCommandUseCaseInput $input
     * @return DacapoCommandUseCaseOutput
     */
    public function handle(DacapoCommandUseCaseInput $input): DacapoCommandUseCaseOutput
    {
        $list = [];
        foreach ($input->schemaBodies as $tableName => $tableAttributes) {
            $list[] = Schema::factory(new TableName($tableName), $tableAttributes);
        }

        $schemaList = new SchemaList($list);
        $migrationFileList = $this->generator->generate($schemaList);

        $migrationBodies = [];
        foreach ($migrationFileList as $migrationFile) {
            $migrationBodies[] = [
                'name' => $migrationFile->getName(),
                'contents' => $migrationFile->getContents(),
            ];
        }

        return new DacapoCommandUseCaseOutput($migrationBodies);
    }
}
