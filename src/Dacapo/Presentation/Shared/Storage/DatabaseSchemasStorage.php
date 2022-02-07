<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage;

interface DatabaseSchemasStorage
{
    /**
     * @return array<int, string>
     */
    public function getFilePathList(): array;
}
