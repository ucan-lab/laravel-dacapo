<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class Indexes implements IteratorAggregate
{
    private $attributes;

    public function __construct()
    {
        $this->attributes = [];
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
