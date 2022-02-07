<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnModifier;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<ColumnModifier>
 */
final class ColumnModifierList implements IteratorAggregate
{
    /**
     * @var array<int, ColumnModifier>
     */
    private array $attributes;

    /**
     * @param array<int, ColumnModifier> $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return ColumnModifier[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
