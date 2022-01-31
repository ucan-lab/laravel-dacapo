<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

use UcanLab\LaravelDacapo\Dacapo\Application\Shared\Exception\UseCase\InvalidArgumentException;
use function is_array;

final class Reference
{
    private $columns;
    private $references;
    private string $on;
    private ?string $name;

    /**
     * Reference constructor.
     * @param string|array $columns
     * @param string|array $references
     * @param string $on
     * @param string|null $name
     */
    private function __construct(
        $columns,
        $references,
        string $on,
        ?string $name
    ) {
        $this->columns = $columns;
        $this->references = $references;
        $this->on = $on;
        $this->name = $name;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        if (isset($attributes['columns']) === false) {
            throw new InvalidArgumentException('foreign_keys.columns field is required');
        }

        if (isset($attributes['references']) === false) {
            throw new InvalidArgumentException('foreign_keys.references field is required');
        }

        if (isset($attributes['on']) === false) {
            throw new InvalidArgumentException('foreign_keys.on field is required');
        }

        return new self($attributes['columns'], $attributes['references'], $attributes['on'], $attributes['name'] ?? null);
    }

    /**
     * @return string
     */
    public function makeForeignMigration(): string
    {
        if ($this->name) {
            return sprintf("->foreign(%s, '%s')->references(%s)->on('%s')", $this->makeColumnsMigration(), $this->name, $this->makeReferencesMigration(), $this->on);
        }

        return sprintf("->foreign(%s)->references(%s)->on('%s')", $this->makeColumnsMigration(), $this->makeReferencesMigration(), $this->on);
    }

    /**
     * @return string
     */
    public function makeDropForeignMigration(): string
    {
        if ($this->name) {
            return sprintf("->dropForeign('%s')", $this->name);
        }

        if (is_array($this->columns)) {
            return sprintf("->dropForeign(['%s'])", implode("', '", $this->columns));
        }

        return sprintf("->dropForeign(['%s'])", $this->columns);
    }

    /**
     * @return bool
     */
    public function hasName(): bool
    {
        return $this->name !== null;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    private function makeColumnsMigration(): string
    {
        if (is_array($this->columns)) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("'%s'", $this->columns);
    }

    /**
     * @return string
     */
    private function makeReferencesMigration(): string
    {
        if (is_array($this->references)) {
            return sprintf("['%s']", implode("', '", $this->references));
        }

        return sprintf("'%s'", $this->references);
    }
}
