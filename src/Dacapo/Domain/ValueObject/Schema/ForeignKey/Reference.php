<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ForeignKey;

class Reference
{
    protected $columns;
    protected $references;
    protected string $on;
    protected ?string $name;

    /**
     * Reference constructor.
     * @param string|array $columns
     * @param string|array $references
     * @param string $on
     * @param string|null $name
     */
    public function __construct($columns, $references, string $on, ?string $name)
    {
        $this->columns = $columns;
        $this->references = $references;
        $this->on = $on;
        $this->name = $name;
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
