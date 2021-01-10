<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

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
     * @return bool
     */
    public function exists(): bool
    {
        if (empty($this->attributes)) {
            return false;
        }

        return true;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
