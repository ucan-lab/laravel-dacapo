<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase\Console;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class DacapoUninstallCommandUseCase
{
    protected SchemasStorage $storage;

    /**
     * DacapoUninstallCommandUseCase constructor.
     * @param SchemasStorage $storage
     */
    public function __construct(SchemasStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return bool
     */
    public function handle(): bool
    {
        return $this->storage->deleteDirectory();
    }
}
