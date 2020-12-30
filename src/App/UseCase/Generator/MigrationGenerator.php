<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Generator;

use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Port\MigrationListRepository;
use UcanLab\LaravelDacapo\App\UseCase\Converter\SchemaToConstraintForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\Converter\SchemaToCreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\Converter\SchemaToCreateTableMigrationConverter;

class MigrationGenerator
{
    protected MigrationListRepository $repository;
    protected SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter;
    protected SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter;
    protected SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter;

    /**
     * MigrationGenerator constructor.
     * @param MigrationListRepository $repository
     * @param SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter
     * @param SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter
     * @param SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
     */
    public function __construct(
        MigrationListRepository $repository,
        SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter,
        SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter,
        SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
    ) {
        $this->repository = $repository;
        $this->schemaToCreateTableMigrationConverter = $schemaToCreateTableMigrationConverter;
        $this->schemaToCreateIndexMigrationConverter = $schemaToCreateIndexMigrationConverter;
        $this->schemaToConstraintForeignKeyMigrationConverter = $schemaToConstraintForeignKeyMigrationConverter;
    }

    /**
     * @param SchemaList $schemaList
     */
    public function generate(SchemaList $schemaList): void
    {
        foreach ($schemaList as $schema) {
            if ($schema->hasColumnList()) {
                [$name, $contents] = $this->schemaToCreateTableMigrationConverter->convert($schema);
                $this->repository->saveFile($name, $contents);
            }

            if ($schema->hasSqlIndexList()) {
                [$name, $contents] = $this->schemaToCreateIndexMigrationConverter->convert($schema);
                $this->repository->saveFile($name, $contents);
            }

            if ($schema->hasForeignKeyList()) {
                [$name, $contents] = $this->schemaToConstraintForeignKeyMigrationConverter->convert($schema);
                $this->repository->saveFile($name, $contents);
            }
        }
    }
}
