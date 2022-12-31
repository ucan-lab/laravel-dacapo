<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema;

use ArrayIterator;
use function in_array;
use IteratorAggregate;
use UcanLab\LaravelDacapo\Dacapo\Domain\Shared\Exception\Schema\DuplicatedTableNameException;

/**
 * @implements IteratorAggregate<Schema>
 */
final class SchemaList implements IteratorAggregate
{
    /**
     * @param array<int, Schema> $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    /**
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

            in_array($schema->getTableName(), $tableNames, true) ?: throw new DuplicatedTableNameException(sprintf('[%s] table name is already in use', $schema->getTableName()));
            $this->attributes[] = $schema;
        }

        return $this;
    }

    /**
     * @return ArrayIterator<int, Schema>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
