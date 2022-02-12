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
     * @var array<int, Column>
     */
    private array $attributes;

    /**
     * @param array<int, Column> $attributes
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
