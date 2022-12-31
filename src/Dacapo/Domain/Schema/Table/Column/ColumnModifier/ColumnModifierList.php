<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column\ColumnModifier;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<ColumnModifier>
 */
final class ColumnModifierList implements IteratorAggregate
{
    /**
     * @param array<int, ColumnModifier> $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    /**
     * @return ArrayIterator<int, ColumnModifier>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
