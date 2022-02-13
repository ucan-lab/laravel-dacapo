<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class InMemoryDatabaseSchemasStorage implements DatabaseSchemasStorage
{
    /**
     * @param array<int, string> $filePathList
     */
    public function __construct(private array $filePathList)
    {
    }

    /**
     * @return array<int, string>
     */
    public function getFilePathList(): array
    {
        return $this->filePathList;
    }
}
