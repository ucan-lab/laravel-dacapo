<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType\IndexModifierType;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier\IndexModifierType\IndexModifierTypeFactory;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\IndexModifier\InvalidArgumentException;
use function is_array;

final class IndexModifier
{
    /**
     * @var IndexModifierType
     */
    private IndexModifierType $type;

    /**
     * @var string|array
     */
    private $columns;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var string|null
     */
    private ?string $algorithm;

    /**
     * Index constructor.
     * @param string|array $columns
     * @param IndexModifierType $type
     * @param string|null $name = null
     * @param string|null $algorithm = null
     */
    private function __construct(
        IndexModifierType $type,
        $columns,
        ?string $name = null,
        ?string $algorithm = null
    ) {
        $this->type = $type;
        $this->columns = $columns;
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function factory(array $attributes): self
    {
        if (isset($attributes['type']) === false) {
            throw new InvalidArgumentException('index_modifier .type field is required');
        }

        if (isset($attributes['columns']) === false) {
            throw new InvalidArgumentException('foreign_keys.columns field is required');
        }

        $indexType = IndexModifierTypeFactory::factory($attributes['type']);
        $columns = $attributes['columns'];
        $name = $attributes['name'] ?? null;
        $algorithm = $attributes['algorithm'] ?? null;

        return new self($indexType, $columns, $name, $algorithm);
    }

    /**
     * @return string
     * @throws
     */
    public function createIndexMigrationUpMethod(): string
    {
        if ($this->hasArgs()) {
            return '$table->' . sprintf('%s(%s, %s);', $this->type->getUpMethodName(), $this->getColumns(), $this->makeArgs());
        }

        return '$table->' . sprintf('%s(%s);', $this->type->getUpMethodName(), $this->getColumns());
    }

    /**
     * @return string
     */
    public function createIndexMigrationDownMethod(): string
    {
        if ($this->name) {
            return '$table->' . sprintf("%s('%s');", $this->type->getDownMethodName(), $this->name);
        } elseif (is_array($this->columns)) {
            return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), implode("', '", $this->columns));
        }

        return '$table->' . sprintf("%s(['%s']);", $this->type->getDownMethodName(), $this->columns);
    }

    /**
     * @return string
     */
    private function getColumns(): string
    {
        if (is_array($this->columns)) {
            return sprintf("['%s']", implode("', '", $this->columns));
        }

        return sprintf("'%s'", $this->columns);
    }

    /**
     * @return bool
     */
    private function hasArgs(): bool
    {
        if ($this->name) {
            return true;
        }

        if ($this->algorithm) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
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
}
