<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

interface SchemasStorage
{
    public function makeDirectory(): bool;

    public function deleteDirectory(): bool;

    public function getFiles(): array;

    public function getYamlContent(string $name): array;

    public function saveFile(string $name, string $content): bool;

    public function getLaravelDefaultSchemaFile(string $version): string;
}
