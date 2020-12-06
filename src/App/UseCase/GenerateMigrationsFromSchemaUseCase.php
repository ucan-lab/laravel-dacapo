<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

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

    public function handle(): void
    {
        $schemas = [];

        foreach ($this->storage->getFiles() as $file) {
            $yaml = $this->storage->getYamlContent($file);

            $schemas[] = SchemaList::factoryFromYaml($yaml);
            var_dump($schemas);
        }
    }
}
