<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\Entity;

use ArrayIterator;
use IteratorAggregate;

class SchemaList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * Schema constructor.
     * @param array $attributes
     */
    public function __construct(
        array $attributes
    ) {
        $this->attributes = $attributes;
    }

    public static function factoryFromYaml(array $yaml): self
    {
        $schemaList = new self([]);

        foreach ($yaml as $tableName => $tableAttributes) {
            $schema = Schema::factoryFromYaml($tableName, $tableAttributes);
            $schemaList->add($schema);
        }

        return $schemaList;
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
     * @return ArrayIterator
     */
    function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
