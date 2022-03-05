<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Generator\MigrationGenerator;
use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class DacapoCommandUseCase
{
    /**
     * @param MigrationGenerator $generator
     * @param DatabaseSchemasStorage $databaseSchemasStorage
     */
    public function __construct(
        private MigrationGenerator $generator,
        private DatabaseSchemasStorage $databaseSchemasStorage,
    ) {
    }

    /**
     * @return DacapoCommandUseCaseOutput
     */
    public function handle(): DacapoCommandUseCaseOutput
    {
        $schemaList = $this->databaseSchemasStorage->getSchemaList();
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
