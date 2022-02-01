<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnType;

use UcanLab\LaravelDacapo\Dacapo\Domain\Schema\Column\ColumnName;
use function is_int;

final class SoftDeletesType implements ColumnType
{
    private ?int $precision = null;

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
            return '->softDeletes()';
        }

        if (is_int($this->precision)) {
            return sprintf("->softDeletes('%s', %d)", $columnName->getName(), $this->precision);
        }

        return sprintf("->softDeletes('%s')", $columnName->getName());
    }
}
