<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class DacapoInitCommandUseCase
{
    protected SchemasStorage $storage;

    /**
     * DacapoInitCommandUseCase constructor.
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
        $this->storage->saveFile('default.yml', $this->storage->getLaravelDefaultSchemaFile($version));

        return true;
    }
}
