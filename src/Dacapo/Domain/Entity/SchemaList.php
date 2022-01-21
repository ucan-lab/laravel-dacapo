<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Entity;

use ArrayIterator;
use Exception;
use IteratorAggregate;

class SchemaList implements IteratorAggregate
{
    /**
     * @var Schema[]
     */
    protected array $attributes = [];

    /**
     * Schema constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param Schema $schema
     * @return SchemaList
     */
    public function add(Schema $schema): self
    {
        $this->attributes[] = $schema;

        return $this;
    }

    /**
     * @param SchemaList $schemaList
     * @return SchemaList
     * @throws
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
                throw new Exception(sprintf('[%s] table name is already in use', $schema->getTableName()));
            }

            $this->attributes[] = $schema;
        }

        return $this;
    }

    /**
     * @return Schema[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
