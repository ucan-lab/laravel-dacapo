<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Presentation\Shared\Storage;

interface DatabaseMigrationsStorage
{
    public function saveFile(string $fileName, string $fileContents): void;
}
