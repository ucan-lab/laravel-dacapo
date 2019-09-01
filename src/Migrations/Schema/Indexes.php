<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class Indexes implements IteratorAggregate
{
    private $attributes;

    /**
     * @param string $tableName
     * @param array $indexesAttributes
     */
    public function __construct(string $tableName, array $indexesAttributes)
    {
        $this->attributes = [];

        foreach ($indexesAttributes as $indexAttributes) {
            $this->add(new Index($tableName, $indexAttributes));
        }
    }

    /**
     * @param Index $index
     * @return self
     */
    public function add(Index $index): self
    {
        $this->attributes[] = $index;

        return $this;
    }

    /**
     * @return integer
     */
    public function count(): int
    {
        if ($this->attributes) {
            return count($this->attributes);
        }

        return 0;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
