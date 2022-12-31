<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

use function count;
use function is_string;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\ForeignKey\InvalidArgumentException;

final class Reference
{
    /**
     * Reference constructor.
     * @param array<int, string> $columns
     * @param array<int, string> $references
     */
    private function __construct(
        private array $columns,
        private array $references,
        private string $table,
        private ?string $name,
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        $attributes['columns'] ?? throw new InvalidArgumentException('foreign_keys.columns field is required');
        $attributes['references'] ?? throw new InvalidArgumentException('foreign_keys.references field is required');
        $attributes['table'] ?? throw new InvalidArgumentException('foreign_keys.table field is required');

        return new self(
            is_string($attributes['columns']) ? self::parse($attributes['columns']) : $attributes['columns'],
            is_string($attributes['references']) ? self::parse($attributes['references']) : $attributes['references'],
            $attributes['table'],
            $attributes['name'] ?? null
        );
    }

    public function makeForeignMigration(): string
    {
        if ($this->name) {
            return sprintf("->foreign(%s, '%s')->references(%s)->on('%s')", $this->makeColumnsMigration(), $this->name, $this->makeReferencesMigration(), $this->table);
        }

        return sprintf("->foreign(%s)->references(%s)->on('%s')", $this->makeColumnsMigration(), $this->makeReferencesMigration(), $this->table);
    }

    public function makeDropForeignMigration(): string
    {
        if ($this->name) {
            return sprintf("->dropForeign('%s')", $this->name);
        }

        return sprintf("->dropForeign(['%s'])", implode("', '", $this->columns));
    }

    public function hasName(): bool
    {
        return $this->name !== null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function makeColumnsMigration(): string
    {
        if (count($this->columns) > 1) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("'%s'", implode('', $this->columns));
    }

    private function makeReferencesMigration(): string
    {
        if (count($this->references) > 1) {
            return sprintf("['%s']", implode("', '", $this->references));
        }

        return sprintf("'%s'", implode('', $this->references));
    }

    /**
     * @return array<int, string>
     */
    private static function parse(string $columns): array
    {
        return array_map(fn ($column) => trim($column), explode(',', $columns));
    }
}
