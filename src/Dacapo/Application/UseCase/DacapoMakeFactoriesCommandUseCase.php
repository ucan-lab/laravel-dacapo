<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoMakeFactoriesCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class DacapoMakeFactoriesCommandUseCase
{
    /**
     * @param DatabaseSchemasStorage $databaseSchemasStorage
     */
    public function __construct(
        private DatabaseSchemasStorage $databaseSchemasStorage,
    ) {
    }

    /**
     * @return DacapoMakeFactoriesCommandUseCaseOutput
     */
    public function handle(): DacapoMakeFactoriesCommandUseCaseOutput
    {
        $schemaList = $this->databaseSchemasStorage->getSchemaList();

        $tableNameList = [];

        /** @var Schema $schema */
        foreach ($schemaList as $schema) {
            $tableNameList[] = $schema->getTableName();
        }

        return new DacapoMakeFactoriesCommandUseCaseOutput($tableNameList);
    }
}
