<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema;

use ArrayIterator;
use IteratorAggregate;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\DuplicatedTableNameException;
use function in_array;

/**
 * @implements IteratorAggregate<Schema>
 */
final class SchemaList implements IteratorAggregate
{
    /**
     * @var array<int, Schema>
     */
    private array $attributes;

    /**
     * @param array<int, Schema> $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param SchemaList $schemaList
     * @return $this
     */
    public function merge(self $schemaList): self
    {
        $tableNames = [];

        foreach ($this->attributes as $attribute) {
            $tableNames[] = $attribute->getTableName();
        }

        foreach ($schemaList as $schema) {
            $schema->getTableName();

            if (in_array($schema->getTableName(), $tableNames, true)) {
                throw new DuplicatedTableNameException(sprintf('[%s] table name is already in use', $schema->getTableName()));
            }

            $this->attributes[] = $schema;
        }

        return $this;
    }

    /**
     * @return Schema[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
