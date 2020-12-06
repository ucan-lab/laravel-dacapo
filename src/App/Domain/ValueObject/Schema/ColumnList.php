<?php declare( strict_types=1 );

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use IteratorAggregate;
use ArrayIterator;

class ColumnList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param Column $column
     * @return ColumnList
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
