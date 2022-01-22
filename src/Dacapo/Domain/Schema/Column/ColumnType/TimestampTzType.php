<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

class TimestampTzType implements ColumnType
{
    /**
     * @var int|null
     */
    protected ?int $args;

    public function __construct(?int $args = null)
    {
        $this->args = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if (is_int($this->args)) {
            return sprintf("->timestampTz('%s', %d)", $columnName->getName(), $this->args);
        }

        return sprintf("->timestampTz('%s')", $columnName->getName());
    }
}
