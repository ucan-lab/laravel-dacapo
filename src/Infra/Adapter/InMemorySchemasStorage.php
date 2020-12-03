<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class InMemorySchemasStorage implements SchemasStorage
{
    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        return true;
    }
}
