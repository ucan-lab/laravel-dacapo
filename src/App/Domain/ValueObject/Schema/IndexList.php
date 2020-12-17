<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

class IndexList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param Index $index
     * @return IndexList
     */
    public function add(Index $index): self
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
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
