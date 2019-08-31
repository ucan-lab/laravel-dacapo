<?php

namespace UcanLab\LaravelDacapo\Migrations\Schema;

use IteratorAggregate;
use ArrayIterator;

class ForeignKeys implements IteratorAggregate
{
    private $attributes;

    /**
     * @param array $relationsAttributes
     */
    public function __construct(array $relationsAttributes)
    {
        $this->attributes = [];

        foreach ($relationsAttributes as $relationAttributes) {
            $this->add(new ForeignKey($relationAttributes));
        }
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
