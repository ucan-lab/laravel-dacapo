<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column;

use ArrayIterator;
use IteratorAggregate;

/**
 * @implements IteratorAggregate<Column>
 */
final class ColumnList implements IteratorAggregate
{
    /**
     * @param array<int, Column> $attributes
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
     * @return ArrayIterator<int, Column>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
