<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Port;

use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFile;

interface SchemaListRepository
{
    public function get(): SchemaList;

    public function makeDirectory(): bool;

    public function deleteDirectory(): bool;

    public function saveFile(SchemaFile $file): bool;

    public function getLaravelDefaultSchemaFile(string $version): string;
}
