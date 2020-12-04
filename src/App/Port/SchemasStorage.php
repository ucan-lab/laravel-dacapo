<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

interface SchemasStorage
{
    public function makeDirectory(): bool;

    public function deleteDirectory(): bool;

    public function saveFile(string $name, string $content): bool;
}
