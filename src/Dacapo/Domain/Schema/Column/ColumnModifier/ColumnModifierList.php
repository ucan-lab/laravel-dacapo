<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

use ArrayIterator;
use IteratorAggregate;

final class ColumnModifierList implements IteratorAggregate
{
    protected array $attributes = [];

    /**
     * @param ColumnModifier $columnModifier
     * @return ColumnModifierList
     */
    public function add(ColumnModifier $columnModifier): self
    {
        $this->attributes[] = $columnModifier;

        return $this;
    }

    /**
     * @return ColumnModifier[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
