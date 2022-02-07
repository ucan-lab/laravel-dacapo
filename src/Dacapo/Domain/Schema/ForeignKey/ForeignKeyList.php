<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\ForeignKey;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<ForeignKey>
 */
final class ForeignKeyList implements IteratorAggregate
{
    /**
     * @var array<int, ForeignKey>
     */
    private array $attributes;

    /**
     * @param array<int, ForeignKey> $attributes
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
     * @return ArrayIterator<int, ForeignKey>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
