<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Infra\Adapter;

use UcanLab\LaravelDacapo\App\Domain\Entity\SchemaList;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\SchemaFile;
use UcanLab\LaravelDacapo\App\Port\SchemaListRepository;

class InMemorySchemaListRepository implements SchemaListRepository
{
    /**
     * @return SchemaList
     */
    public function get(): SchemaList
    {
        return new SchemaList();
    }

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
     * @return array
     */
    public function getFiles(): array
    {
        return [];
    }

    /**
     * @param string $name
     * @return array
     */
    public function getYamlContent(string $name): array
    {
        return [];
    }

    /**
     * @param SchemaFile $file
     * @return bool
     */
    public function saveFile(SchemaFile $file): bool
    {
        return true;
    }

    /**
     * @param string $version
     * @return string
     */
    public function getLaravelDefaultSchemaFile(string $version): string
    {
        return file_get_contents(__DIR__ . '/../Storage/default-schemas/' . $version . '.yml');
    }
}
