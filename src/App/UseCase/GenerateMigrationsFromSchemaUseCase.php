<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

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
        foreach ($this->storage->getFiles() as $file) {
            $yaml = $this->storage->getYamlContent($file);

            dump($yaml);
        }
    }
}
