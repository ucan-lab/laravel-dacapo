<?php declare(strict_types=1);

namespace UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnName;
use UcanLab\LaravelDacapo\App\Domain\ValueObject\Schema\ColumnType;

class UnsignedDecimalType implements ColumnType
{
    /**
     * @param ColumnName $columnName
     * @return string
     */
    public function createMigrationMethod(ColumnName $columnName): string
    {
        $args = $columnName->getArgs();

        if (is_array($args) && count($args) === 2) {
            return sprintf("->unsignedDecimal('%s', %d, %d)", $columnName->getName(), $args[0], $args[1]);
        } elseif (is_array($args) && count($args) === 1) {
            return sprintf("->unsignedDecimal('%s', %d)", $columnName->getName(), $args[0]);
        } elseif (is_int($args)) {
            return sprintf("->unsignedDecimal('%s', %s)", $columnName->getName(), $args);
        } elseif (is_string($args)) {
            return sprintf("->unsignedDecimal('%s', %s)", $columnName->getName(), $args);
        }

        return sprintf("->unsignedDecimal('%s')", $columnName->getName());
    }
}
