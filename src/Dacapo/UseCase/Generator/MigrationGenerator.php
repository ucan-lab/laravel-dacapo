<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\UseCase\Generator;

use UcanLab\LaravelDacapo\Dacapo\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Migration\MigrationFileList;
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
     * @return MigrationFileList
     */
    public function generate(SchemaList $schemaList): MigrationFileList
    {
        $tableFileList = $this->generateCreateTable($schemaList);
        $indexFileList = $this->generateCreateIndex($schemaList);
        $foreignKeyFileList = $this->generateConstraintForeignKey($schemaList);

        return $tableFileList->merge($indexFileList)->merge($foreignKeyFileList);
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function generateCreateTable(SchemaList $schemaList): MigrationFileList
    {
        $fileList = $this->schemaToCreateTableMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);

        return $fileList;
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function generateCreateIndex(SchemaList $schemaList): MigrationFileList
    {
        $fileList = $this->schemaToCreateIndexMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);

        return $fileList;
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function generateConstraintForeignKey(SchemaList $schemaList): MigrationFileList
    {
        $fileList = $this->schemaToConstraintForeignKeyMigrationConverter->convertList($schemaList);
        $this->repository->saveFileList($fileList);

        return $fileList;
    }
}
