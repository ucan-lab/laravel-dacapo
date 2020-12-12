<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

use Exception;
use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Domain\DomainService\SchemaToCreateForeginKeyClassConverter;
use UcanLab\LaravelDacapo\App\Domain\DomainService\SchemaToCreateIndexClassConverter;
use UcanLab\LaravelDacapo\App\Domain\DomainService\SchemaToCreateTableClassConverter;
use UcanLab\LaravelDacapo\App\Port\MigrationsStorage;
use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class GenerateMigrationsFromSchemaUseCase
{
    protected SchemaList $schemaList;
    protected SchemasStorage $schemasStorage;
    protected MigrationsStorage $migrationsStorage;

    /**
     * GenerateMigrationsFromSchemaUseCase constructor.
     * @param SchemaList $schemaList
     * @param SchemasStorage $schemasStorage
     * @param MigrationsStorage $migrationsStorage
     */
    public function __construct(SchemaList $schemaList, SchemasStorage $schemasStorage, MigrationsStorage $migrationsStorage)
    {
        $this->schemaList = $schemaList;
        $this->schemasStorage = $schemasStorage;
        $this->migrationsStorage = $migrationsStorage;
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
                [$name, $contents] = (new SchemaToCreateTableClassConverter($schema))->convert();
                $this->migrationsStorage->saveFile($name, $contents);
            }

            if ($schema->hasIndexList()) {
                [$name, $contents] = (new SchemaToCreateIndexClassConverter($schema))->convert();
                $this->migrationsStorage->saveFile($name, $contents);
            }

            if ($schema->hasForeignKeyList()) {
                [$name, $contents] = (new SchemaToCreateForeginKeyClassConverter($schema))->convert();
                $this->migrationsStorage->saveFile($name, $contents);
            }
        }
    }
}
