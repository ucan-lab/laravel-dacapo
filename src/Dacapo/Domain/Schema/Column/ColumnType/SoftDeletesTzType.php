<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;
use function is_int;

final class SoftDeletesTzType implements ColumnType
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
            return '->softDeletesTz()';
        }

        if (is_int($this->precision)) {
            return sprintf("->softDeletesTz('%s', %d)", $columnName->getName(), $this->precision);
        }

        return sprintf("->softDeletesTz('%s')", $columnName->getName());
    }
}
