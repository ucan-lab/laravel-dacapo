<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class TimeTzType implements ColumnType
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
            return sprintf("->timeTz('%s', %d)", $columnName->getName(), $this->args);
        }

        return sprintf("->timeTz('%s')", $columnName->getName());
    }
}
