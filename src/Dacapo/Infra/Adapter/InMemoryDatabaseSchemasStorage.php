<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage\DatabaseSchemasStorage;

final class InMemoryDatabaseSchemasStorage implements DatabaseSchemasStorage
{
    /**
     * @var array<int, string>
     */
    private array $filePathList;

    /**
     * @param array<string|false> $filePathList
     */
    public function __construct(array $filePathList)
    {
        $this->filePathList = $filePathList;
    }

    /**
     * @return array<int, string>
     */
    public function getFilePathList(): array
    {
        return $this->filePathList;
    }
}
