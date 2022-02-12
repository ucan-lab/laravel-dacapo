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
     * @param array<int, ForeignKey> $attributes
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
     * @return ArrayIterator<int, ForeignKey>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
