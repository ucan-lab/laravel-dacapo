<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

use Exception;
use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class GenerateMigrationsFromSchemaUseCase
{
    protected SchemasStorage $storage;

    /**
     * GenerateMigrationsFromSchemaUseCase constructor.
     * @param SchemasStorage $storage
     */
    public function __construct(SchemasStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @throws
     */
    public function handle(): void
    {
        $schemaList = new SchemaList();

        foreach ($this->storage->getFiles() as $file) {
            $yaml = $this->storage->getYamlContent($file);

            try {
                $schemaList->merge(SchemaList::factoryFromYaml($yaml));
            } catch (Exception $e) {
                throw new Exception(sprintf('%s, by %s', $e->getMessage(), $file), 0, $e);
            }
        }

        var_dump($schemaList);
    }
}
