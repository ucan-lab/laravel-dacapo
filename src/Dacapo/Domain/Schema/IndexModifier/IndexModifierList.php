<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<IndexModifier>
 */
final class IndexModifierList implements IteratorAggregate
{
    /**
     * @param array<int, IndexModifier> $attributes
     */
    public function __construct(private array $attributes)
    {
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return ! (empty($this->attributes));
    }

    /**
     * @return ArrayIterator<int, IndexModifier>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
