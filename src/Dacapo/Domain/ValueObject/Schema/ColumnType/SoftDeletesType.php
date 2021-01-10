<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class SoftDeletesType implements ColumnType
{
    protected ?int $precision = null;

    /**
     * SoftDeletesType constructor.
     * @param int|null $args
     */
    public function __construct(?int $args = null)
    {
        $this->precision = $args;
    }

    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        if ($columnName->getName() === '') {
            return sprintf('->softDeletes()');
        }

        if (is_int($this->precision)) {
            return sprintf("->softDeletes('%s', %d)", $columnName->getName(), $this->precision);
        }

        return sprintf("->softDeletes('%s')", $columnName->getName());
    }
}
