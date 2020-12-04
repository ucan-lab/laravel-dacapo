<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\App\Port\SchemasStorage;

class InMemorySchemasStorage implements SchemasStorage
{
    /**
     * @return bool
     */
    public function makeDirectory(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function deleteDirectory(): bool
    {
        return true;
    }

    /**
     * @param string $name
     * @param string $content
     * @return bool
     */
    public function saveFile(string $name, string $content): bool
    {
        return true;
    }
}
