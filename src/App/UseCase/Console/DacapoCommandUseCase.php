<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use Exception;
use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;
use UcanLab\LaravelDacapo\App\Port\SchemasStorage;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateForeignKeyMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateIndexMigrationConverter;
use UcanLab\LaravelDacapo\App\UseCase\SchemaConverter\CreateTableMigrationConverter;

class DacapoCommandUseCase
{
    protected SchemaList $schemaList;
    protected SchemasStorage $schemasStorage;
    protected MigrationsStorage $migrationsStorage;
    protected CreateTableMigrationConverter $createTableMigrationConverter;
    protected CreateIndexMigrationConverter $createIndexMigrationConverter;
    protected CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter;

    /**
     * DacapoCommandUseCase constructor.
     * @param SchemaList $schemaList
     * @param SchemasStorage $schemasStorage
     * @param MigrationsStorage $migrationsStorage
     * @param CreateTableMigrationConverter $createTableMigrationConverter
     * @param CreateIndexMigrationConverter $createIndexMigrationConverter
     * @param CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter
     */
    public function __construct (
        SchemaList $schemaList,
        SchemasStorage $schemasStorage,
        MigrationsStorage $migrationsStorage,
        CreateTableMigrationConverter $createTableMigrationConverter,
        CreateIndexMigrationConverter $createIndexMigrationConverter,
        CreateForeignKeyMigrationConverter $createForeignKeyMigrationConverter
    ) {
        $this->schemaList = $schemaList;
        $this->schemasStorage = $schemasStorage;
        $this->migrationsStorage = $migrationsStorage;
        $this->createTableMigrationConverter = $createTableMigrationConverter;
        $this->createIndexMigrationConverter = $createIndexMigrationConverter;
        $this->createForeignKeyMigrationConverter = $createForeignKeyMigrationConverter;
    }

    /**
     * @throws
     */
    public function handle(): void
    {
        $this->makeSchemaList();
        $this->writeMigration();
    }

    /**
     * @throws
     */
    protected function makeSchemaList(): void
    {
        foreach ($this->schemasStorage->getFiles() as $file) {
            $yaml = $this->schemasStorage->getYamlContent($file);

            try {
                $this->schemaList->merge(SchemaList::factoryFromYaml($yaml));
            } catch (Exception $e) {
                throw new Exception(sprintf('%s, by %s', $e->getMessage(), $file), 0, $e);
            }
        }
    }

    protected function writeMigration(): void
    {
        foreach ($this->schemaList as $schema) {
            if ($schema->hasColumnList()) {
                [$name, $contents] = $this->createTableMigrationConverter->convert($schema);
                $this->migrationsStorage->saveFile($name, $contents);
            }

            if ($schema->hasIndexList()) {
                [$name, $contents] = $this->createIndexMigrationConverter->convert($schema);
                $this->migrationsStorage->saveFile($name, $contents);
            }

            if ($schema->hasForeignKeyList()) {
                [$name, $contents] = $this->createForeignKeyMigrationConverter->convert($schema);
                $this->migrationsStorage->saveFile($name, $contents);
            }
        }
    }
}
