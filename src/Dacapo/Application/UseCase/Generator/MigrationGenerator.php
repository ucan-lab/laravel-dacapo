<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Generator;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Converter\SchemaToConstraintForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Converter\SchemaToCreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Converter\SchemaToCreateTableMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Domain\Migration\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

class MigrationGenerator
{
    protected SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter;
    protected SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter;
    protected SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter;

    /**
     * MigrationGenerator constructor.
     * @param SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter
     * @param SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter
     * @param SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
     */
    public function __construct(
        SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter,
        SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter,
        SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
    ) {
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
        return $this->schemaToCreateTableMigrationConverter->convertList($schemaList);
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function generateCreateIndex(SchemaList $schemaList): MigrationFileList
    {
        return $this->schemaToCreateIndexMigrationConverter->convertList($schemaList);
    }

    /**
     * @param SchemaList $schemaList
     * @return MigrationFileList
     */
    public function generateConstraintForeignKey(SchemaList $schemaList): MigrationFileList
    {
        return $this->schemaToConstraintForeignKeyMigrationConverter->convertList($schemaList);
    }
}
