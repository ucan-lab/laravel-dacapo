<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoMakeModelsCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class DacapoMakeModelsCommandUseCase
{
    /**
     * @param DatabaseSchemasStorage $databaseSchemasStorage
     */
    public function __construct(
        private DatabaseSchemasStorage $databaseSchemasStorage,
    ) {
    }

    /**
     * @return DacapoMakeModelsCommandUseCaseOutput
     */
    public function handle(): DacapoMakeModelsCommandUseCaseOutput
    {
        $schemaList = $this->databaseSchemasStorage->getSchemaList();

        $tableNameList = [];

        /** @var Schema $schema */
        foreach ($schemaList as $schema) {
            $tableNameList[] = $schema->getTableName();
        }

        return new DacapoMakeModelsCommandUseCaseOutput($tableNameList);
    }
}
