<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use ArrayIterator;
use IteratorAggregate;

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

    /**
     * @return bool
     */
    public function hasDefaultRaw(): bool
    {
        foreach ($this as $column) {
            if ($column->existsDefaultRaw()) {
                return true;
            }
        }

        return false;
    }
}
