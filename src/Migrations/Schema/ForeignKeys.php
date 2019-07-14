<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class ForeignKeys implements IteratorAggregate
{
    private $attributes;

    public function __construnct()
    {
        $this->attributes = [];
    }

    public function add(ForeignKey $foreignKey): self
    {
        $this->attributes[] = $foreignKey;

        return $this;
    }

    public function count(): int
    {
        if ($this->attributes) {
            return count($this->attributes);
        }

        return 0;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
