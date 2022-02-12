<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Generator;

use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Converter\SchemaToConstraintForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Converter\SchemaToCreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Application\UseCase\Shared\Converter\SchemaToCreateTableMigrationConverter;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFileList;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\SchemaList;

final class MigrationGenerator
{
    /**
     * MigrationGenerator constructor.
     * @param SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter
     * @param SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter
     * @param SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
     */
    public function __construct(
        private SchemaToCreateTableMigrationConverter $schemaToCreateTableMigrationConverter,
        private SchemaToCreateIndexMigrationConverter $schemaToCreateIndexMigrationConverter,
        private SchemaToConstraintForeignKeyMigrationConverter $schemaToConstraintForeignKeyMigrationConverter
    ) {
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

        $fileList = $tableFileList->get() + $indexFileList->get() + $foreignKeyFileList->get();
        ksort($fileList);

        return new MigrationFileList($fileList);
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
