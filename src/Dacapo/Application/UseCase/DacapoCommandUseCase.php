<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Output\DacapoCommandUseCaseOutput;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Driver\DatabaseDriver;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationCreateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\Stub\MigrationUpdateStub;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Schema;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseMigrationsStorage;
use UcanLab\LaravelDacapo\Dacapo\Storage\DatabaseSchemasStorage;

final class DacapoCommandUseCase
{
    public function __construct(
        private DatabaseSchemasStorage $databaseSchemasStorage,
        private DatabaseMigrationsStorage $databaseMigrationsStorage,
        private DatabaseDriver $databaseBuilder,
        private MigrationCreateStub $migrationCreateStub,
        private MigrationUpdateStub $migrationUpdateStub,
    ) {
    }

    public function handle(): DacapoCommandUseCaseOutput
    {
        $schemaList = $this->databaseSchemasStorage->getSchemaList();

        $generatedFileNameList = $this->generateCreateTableMigrationFile($schemaList);
        $generatedFileNameList = array_merge($generatedFileNameList, $this->generateCreateIndexMigrationFile($schemaList));
        $generatedFileNameList = array_merge($generatedFileNameList, $this->generateConstraintForeignKeyMigrationFile($schemaList));

        sort($generatedFileNameList);

        return new DacapoCommandUseCaseOutput($generatedFileNameList);
    }

    /**
     * @return array<int, string>
     */
    private function generateCreateTableMigrationFile(SchemaList $schemaList): array
    {
        $fileNameList = [];

        /** @var Schema $schema */
        foreach ($schemaList as $schema) {
            $migrationFile = $schema->makeCreateTableMigrationFile($this->databaseBuilder, $this->migrationCreateStub);
            $this->databaseMigrationsStorage->save($migrationFile);
            $fileNameList[] = $migrationFile->getName();
        }

        return $fileNameList;
    }

    /**
     * @return array<int, string>
     */
    private function generateCreateIndexMigrationFile(SchemaList $schemaList): array
    {
        $fileNameList = [];

        /** @var Schema $schema */
        foreach ($schemaList as $schema) {
            $migrationFile = $schema->makeCreateIndexMigrationFile($this->migrationUpdateStub);
            if ($migrationFile) {
                $this->databaseMigrationsStorage->save($migrationFile);
                $fileNameList[] = $migrationFile->getName();
            }
        }

        return $fileNameList;
    }

    /**
     * @return array<int, string>
     */
    private function generateConstraintForeignKeyMigrationFile(SchemaList $schemaList): array
    {
        $fileNameList = [];

        /** @var Schema $schema */
        foreach ($schemaList as $schema) {
            $migrationFile = $schema->makeConstraintForeignKeyMigrationFile($this->migrationUpdateStub);
            if ($migrationFile) {
                $this->databaseMigrationsStorage->save($migrationFile);
                $fileNameList[] = $migrationFile->getName();
            }
        }

        return $fileNameList;
    }
}
