<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;

class IndexModifierList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param IndexModifier $index
     * @return IndexModifierList
     */
    public function add(IndexModifier $index): self
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
     * @return IndexModifier[] | ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
