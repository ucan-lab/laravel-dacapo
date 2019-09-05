<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use ArrayIterator;
use IteratorAggregate;

class Tables implements IteratorAggregate
{
    private $attributes;

    public function __construct()
    {
        $this->attributes = [];
    }

    /**
     * @param Table $table
     * @return self
     */
    public function add(Table $table): self
    {
        $this->attributes[] = $table;

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
