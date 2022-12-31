<?php

declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Table\Column;

use ArrayIterator;
use IteratorAggregate;
use UcanLab\LaravelDacapo\Dacapo\Domain\MigrationFile\MigrationFile;

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

    public function makeMigration(): string
    {
        $str = '';

        foreach ($this->attributes as $column) {
            $str .= $column->makeMigration() . PHP_EOL . MigrationFile::MIGRATION_COLUMN_INDENT;
        }

        return $str;
    }
}
