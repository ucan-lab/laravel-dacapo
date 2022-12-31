<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use function count;
use function is_array;
use function is_string;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType\IndexModifierType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType\IndexModifierTypeFactory;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\IndexModifier\InvalidArgumentException;

final class IndexModifier
{
    /**
     * IndexModifier constructor.
     * @param array<int, string> $columns
     * @param string|null $name = null
     * @param string|null $algorithm = null
     * @param string|null $language = null
     */
    private function __construct(
        private IndexModifierType $type,
        private array $columns,
        private ?string $name = null,
        private ?string $algorithm = null,
        private ?string $language = null,
    ) {
    }

    /**
     * @param array<string, mixed> $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        $attributes['type'] ?? throw new InvalidArgumentException('IndexModifier type field is required');
        $attributes['columns'] ?? throw new InvalidArgumentException('IndexModifier columns field is required');

        $indexType = IndexModifierTypeFactory::factory($attributes['type']);
        $columns = is_string($attributes['columns']) ? self::parse($attributes['columns']) : $attributes['columns'];
        $name = $attributes['name'] ?? null;
        $algorithm = $attributes['algorithm'] ?? null;
        $language = $attributes['language'] ?? null;

        return new self(
            $indexType,
            $columns,
            $name,
            $algorithm,
            $language
        );
    }

    public function makeUpMigration(): string
    {
        if ($this->hasArgs()) {
            return '$table->' . sprintf('%s(%s, %s)%s;', $this->type->getUpMethodName(), $this->getColumns(), $this->makeArgs(), $this->makeLanguage());
        }

        return '$table->' . sprintf('%s(%s)%s;', $this->type->getUpMethodName(), $this->getColumns(), $this->makeLanguage());
    }

    public function makeDownMigration(): string
    {
        if ($this->name) {
            return '$table->' . sprintf("%s('%s');", $this->type->getDownMethodName(), $this->name);
        } elseif (is_array($this->columns)) {
            return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), implode("', '", $this->columns));
        }

        return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), $this->columns);
    }

    private function getColumns(): string
    {
        if (count($this->columns) > 1) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("'%s'", implode('', $this->columns));
    }

    private function hasArgs(): bool
    {
        if ($this->name) {
            return true;
        }

        return (bool) ($this->algorithm);
    }

    private function makeArgs(): string
    {
        if ($this->name && $this->algorithm) {
            return sprintf("'%s', '%s'", $this->name, $this->algorithm);
        } elseif (empty($this->name) && $this->algorithm) {
            return sprintf("null, '%s'", $this->algorithm);
        } elseif ($this->name && empty($this->algorithm)) {
            return sprintf("'%s'", $this->name);
        }

        throw new InvalidArgumentException('Has no args.');
    }

    private function makeLanguage(): string
    {
        if ($this->language === null) {
            return '';
        }

        return sprintf("->language('%s')", $this->language);
    }

    /**
     * @return array<int, string>
     */
    private static function parse(string $columns): array
    {
        return array_map(fn ($column) => trim($column), explode(',', $columns));
    }
}
