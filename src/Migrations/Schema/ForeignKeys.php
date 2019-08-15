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

    /**
     * @param ForeignKey $foreignKey
     * @return self
     */
    public function add(ForeignKey $foreignKey): self
    {
        $this->attributes[] = $foreignKey;

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
