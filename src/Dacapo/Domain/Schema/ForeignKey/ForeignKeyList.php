<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

use ArrayIterator;
use IteratorAggregate;

final class ForeignKeyList implements IteratorAggregate
{
    private array $attributes;

    /**
     * @param array $attributes
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
     * @return ForeignKey[]|ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
