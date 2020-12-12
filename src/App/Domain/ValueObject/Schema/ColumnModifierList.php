<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema;

use ArrayIterator;
use IteratorAggregate;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\Column\ColumnModifier;

class ColumnModifierList implements IteratorAggregate
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
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
