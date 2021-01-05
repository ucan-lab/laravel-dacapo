<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

class SqlIndexList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param SqlIndex $index
     * @return SqlIndexList
     */
    public function add(SqlIndex $index): self
    {
        $this->attributes[] = $index;

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
     * @return SqlIndex[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
