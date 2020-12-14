<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

class SoftDeletesType implements ColumnType
{
    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        $args = $columnName->getArgs();

        if (is_int($args)) {
            return sprintf("->softDeletes('%s', %d)", $columnName->getName(), $args);
        }

        return sprintf("->softDeletes('%s')", $columnName->getName());
    }
}
