<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\ValueObject\Schema\ColumnType;

class SoftDeletesTzType implements ColumnType
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
            return sprintf('->softDeletesTz()');
        }

        if (is_int($this->precision)) {
            return sprintf("->softDeletesTz('%s', %d)", $columnName->getName(), $this->precision);
        }

        return sprintf("->softDeletesTz('%s')", $columnName->getName());
    }
}
