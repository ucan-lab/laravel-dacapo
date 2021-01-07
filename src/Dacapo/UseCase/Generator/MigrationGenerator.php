<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Generator;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Converter\SchemaToConstraintForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Converter\SchemaToCreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Converter\SchemaToCreateTableMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\UseCase\Port\MigrationListRepository;

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
        $this->generateCreateTable($schemaList);
        $this->generateCreateIndex($schemaList);
        $this->generateConstraintForeignKey($schemaList);
    }

    /**
     * @param SchemaList $schemaList
     */
    public function generateCreateTable(SchemaList $schemaList): void
    {
        $fileList = $this->schemaToCreateTableMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);
    }

    /**
     * @param SchemaList $schemaList
     */
    public function generateCreateIndex(SchemaList $schemaList): void
    {
        $fileList = $this->schemaToCreateIndexMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);
    }

    /**
     * @param SchemaList $schemaList
     */
    public function generateConstraintForeignKey(SchemaList $schemaList): void
    {
        $fileList = $this->schemaToConstraintForeignKeyMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);
    }
}
