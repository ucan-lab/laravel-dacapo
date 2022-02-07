<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\IndexModifier;

use ArrayIterator;
use IteratorAggregate;

final class IndexModifierList implements IteratorAggregate
{
    /**
     * @var array<int, IndexModifier>
     */
    private array $attributes;

    /**
     * @param array<int, IndexModifier> $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
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
     * @return IndexModifier[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
