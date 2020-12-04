<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class InitUseCase
{
    protected SchemasStorage $storage;

    /**
     * InitUseCase constructor.
     * @param SchemasStorage $storage
     */
    public function __construct(SchemasStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $version
     * @return bool
     */
    public function handle(string $version): bool
    {
        $this->storage->makeDirectory();
        $this->storage->saveFile('default.yml', $this->getDefaultSchemaFile($version));

        return true;
    }

    /**
     * @param string $version
     * @return string
     */
    private function getDefaultSchemaFile(string $version): string
    {
        return file_get_contents(__DIR__ . '/../../Infra/Storage/default-schemas/' . $version . '.yml');
    }
}
