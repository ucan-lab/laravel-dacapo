<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage;

interface DatabaseSchemasStorage
{
    public function getFilePathList(): array;
}
