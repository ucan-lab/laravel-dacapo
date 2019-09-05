<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use ArrayIterator;
use IteratorAggregate;

class Relations implements IteratorAggregate
{
    private $attributes;

    /**
     * @param array $relationsAttributes
     */
    public function __construct(array $relationsAttributes)
    {
        $this->attributes = [];

        foreach ($relationsAttributes as $relationAttributes) {
            $this->add(new Relation($relationAttributes));
        }
    }

    /**
     * @param Relation $foreignKey
     * @return self
     */
    public function add(Relation $foreignKey): self
    {
        $this->attributes[] = $foreignKey;

        return $this;
    }

    /**
     * @return int
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
