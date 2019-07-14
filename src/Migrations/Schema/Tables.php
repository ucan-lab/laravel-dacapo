<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class Tables implements IteratorAggregate
{
    private $attributes;

    public function __construnct()
    {
        $this->attributes = [];
    }

    public function add(Table $table): self
    {
        $this->attributes[] = $table;

        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
