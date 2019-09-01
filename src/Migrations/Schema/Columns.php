<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class Columns implements IteratorAggregate
{
    private $attributes;

    /**
     * @param array $columnsAttributes
     */
    public function __construct(array $columnsAttributes)
    {
        $this->attributes = [];

        foreach ($columnsAttributes as $columnName => $columnAttributes) {
            $this->add(new Column($columnName, $columnAttributes));
        }
    }

    /**
     * @param Column $column
     * @return self
     */
    public function add(Column $column): self
    {
        $this->attributes[] = $column;

        return $this;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
