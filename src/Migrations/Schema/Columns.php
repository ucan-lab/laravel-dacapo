<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class Columns implements IteratorAggregate
{
    private $attributes;

    public function __construnct()
    {
        $this->attributes = [];
    }

    public function add(Column $column): self
    {
        $this->attributes[] = $column;

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
