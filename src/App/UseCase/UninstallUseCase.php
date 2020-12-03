<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\UseCase;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class UninstallUseCase
{
    protected SchemasStorage $storage;

    /**
     * UninstallDacapoUseCase constructor.
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
